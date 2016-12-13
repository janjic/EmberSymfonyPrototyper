<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiUpdateAgentManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiUpdateAgentManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function updateResource($data)
    {
        /**
         * @var Agent $agent
         */
        $agent = $this->deserializeAgent($data);

        /**
         * @var Agent $dbAgent
         */
        $dbAgent = $this->getEntityReference($agent->getId());
        /**
         * @var Address $dbAddress
         */
        $dbAddress = $dbAgent->getAddress();

        /**
         * @var Address $address
         */
        $address = $agent->getAddress();
        $dbAddress->setStreetNumber($address->getStreetNumber());
        $dbAddress->setCity($address->getCity());
        $dbAddress->setCountry($address->getCountry());
        $dbAddress->setFixedPhone($address->getFixedPhone());
        $dbAddress->setPhone($address->getPhone());
        $dbAddress->setPostcode($address->getPostcode());

        if(!is_null($agent->getImage()) && $agent->getImage()->getId() == 0) {
            $image = new Image();
            $image->setBase64Content($agent->getImage()->getBase64Content());
            $image->setName($agent->getImage()->getName());

            $image->saveToFile($image->getBase64Content());

            $dbAgent->setImage($image);
        }


        $dbSuperior = $dbAgent->getSuperior();
        $newSuperior = null;
        if(!is_null($agent->getSuperior())){
            $newSuperior = $this->repository->getReference($agent->getSuperior()->getId());
        }

        $agent = $this->edit($dbAgent, $dbSuperior, $newSuperior);

        if($agent->getId()){
            $this->syncWithTCRPortal($agent, 'edit');
        }

        return $agent;
    }

    private function prepareUpdate($data)
    {
        /**
         * @var Agent $agent
         */
        $agent = $this->deserializeAgent($data);

        $agent->setUsername($agent->getEmail());
        $agent->setBirthDate(new DateTime($agent->getBirthDate()));
        /**
         * @var Agent $dbAgent
         */
        $dbAgent = $this->getEntityReference($agent->getId());
        /**
         * @var Address $dbAddress
         */
        $dbAddress = $dbAgent->getAddress();
        $agent->getAddress()->setId($dbAddress->getId());

        if(!is_null($agent->getImage()) && $agent->getImage()->getId() == 0) {
            $image = new Image();
            $image->setBase64Content($agent->getImage()->getBase64Content());
            $image->setName($agent->getImage()->getName());

            $image->saveToFile($image->getBase64Content());

            $dbAgent->setImage($image);
        }


        $dbSuperior = $dbAgent->getSuperior();
        $newSuperior = null;
        if(!is_null($agent->getSuperior())){
            $newSuperior = $this->repository->getReference($agent->getSuperior()->getId());
        }

        $agent = $this->edit($dbAgent, $dbSuperior, $newSuperior);

        if($agent->getId()){
            $this->syncWithTCRPortal($agent, 'edit');
        }

        return $agent;


        $group = $this->groupManager->getEntityReference($agent->getGroup()->getId());
        /**
         * Populate agent object with relationships and image url
         */
        $agent->setGroup($group);

        return $agent;
    }

    private function saveToFile($agent)
    {
        /**  */
        if(!is_null($image = $agent->getImage())){
            if ($image->saveToFile($image->getBase64Content())) {
                $agent->setBaseImageUrl($image->getWebPath());
                return true;
            }
            return false;
        }

        return true;

    }

    /**
     * @param $data
     * @return mixed
     */
    private function createResponse($data):mixed
    {
        switch (get_class($data)) {
            case UniqueConstraintViolationException::class:
                return new ArrayCollection(AgentApiResponse::AGENT_ALREADY_EXIST);
            case (Agent::class && ($id= $data->getId())):
                return new ArrayCollection(AgentApiResponse::AGENT_SAVED_SUCCESSFULLY($id));
            case Exception::class:
                return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
            default:
                return false;
        }
    }



}