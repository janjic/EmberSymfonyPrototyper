<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\AgentApiResponse;
use CoreBundle\Adapter\JQGridConverter;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Business\Manager\GroupManager;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;

/**
 * Class AgentSaveConverter
 * @package UserBundle\Adapter\Agent
 */
class AgentSaveConverter extends JQGridConverter
{
    /**
     * @param AgentManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(AgentManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {

        /**
         * @var Agent $agent
         */
        $agent = $this->manager->deserializeAgent($this->request->getContent());

        $agent->setUsername($agent->getEmail());
        $agent->setBirthDate(new DateTime($agent->getBirthDate()));


        if(!is_null($agent->getImage())){
            $image = new Image();
            $image->setBase64Content($agent->getImage()->getBase64Content());
            $image->setName($agent->getImage()->getName());
            $image->saveToFile($image->getBase64Content());

            $agent->setImage($image);
            $agent->setBaseImageUrl($image->getWebPath());
        }

        /** @var TODO: to reference $group */
        $group = $this->manager->getGroupById($agent->getGroup()->getId());


        /**
         * If agent is not root set his superior agent
         */
        $superior = null;

        if(!is_null($agent->getSuperior())) {
            /** @var TODO: to reference $group */
            $superior = $this->manager->findAgentById($agent->getSuperior()->getId());
        }

        /**
         * Populate agent object with relationships and image url
         */
        $agent->setGroup($group);

        /**
         * @var $agent Agent|Exception
         */
        $agent = $this->manager->save($agent, $superior);

        switch (get_class($agent)) {
            case UniqueConstraintViolationException::class:
                $this->request->attributes->set($this->param, new ArrayCollection(AgentApiResponse::AGENT_ALREADY_EXIST));
                break;
            case (Agent::class && ($id= $agent->getId())):
                $this->request->attributes->set($this->param, new ArrayCollection(AgentApiResponse::AGENT_SAVED_SUCCESSFULLY($id)));
                break;
            case Exception::class:
                $this->request->attributes->set($this->param, new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($agent)));
                break;
            default:
                return;
        }
    }
}