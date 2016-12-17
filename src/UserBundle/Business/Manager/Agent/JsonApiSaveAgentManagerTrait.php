<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiAgentSaveManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiSaveAgentManagerTrait
{
    use SaveMediaTrait;
    /**
     * {@inheritdoc}
     */
    public function saveResource($data)
    {
        $agent = $this->prepareSave($data);
        if ($this->saveMedia($agent)) {
            /** @var Agent|Exception $agent */
            $data = $this->save($agent, is_null($agent->getSuperior())? null:$this->getEntityReference($agent->getSuperior()->getId()));
            /** @var Image|null $image */;
            if ($data instanceof Exception) {
                !is_null($image = $agent->getImage()) ? $image->deleteFile() : false;
                return $this->createJsonAPiSaveResponse($data);
            }
        }

        return $this->createJsonAPiSaveResponse($agent);
    }

    /**
     * @param $data
     * @return Agent
     */
    private function prepareSave($data)
    {
        /**
         * @var Agent $agent
         */
        $agent = $this->deserializeAgent($data);

        $agent->setUsername($agent->getEmail());
        $group = $this->groupManager->getEntityReference($agent->getGroup()->getId());
        /**
         * Populate agent object with relationships and image url
         */
        $agent->setGroup($group);

        return $agent;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        switch (get_class($data)) {
            case UniqueConstraintViolationException::class:
                return new ArrayCollection(AgentApiResponse::AGENT_ALREADY_EXIST);
            case Exception::class:
                return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
            case (Agent::class && ($id= $data->getId())):
                return new ArrayCollection(AgentApiResponse::AGENT_SAVED_SUCCESSFULLY($id));
            case (Agent::class && !($id= $data->getId()) && $data->getImage()):
                return new ArrayCollection(AgentApiResponse::AGENT_SAVED_FILE_FAILED_RESPONSE);
            default:
                return false;
        }
    }


}