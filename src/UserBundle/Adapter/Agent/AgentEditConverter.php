<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\JQGridConverter;
use CoreBundle\Business\Serializer\FSDSerializer;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Business\Manager\GroupManager;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;

/**
 * Class AgentEditConverter
 * @package UserBundle\Adapter\Agent
 */
class AgentEditConverter extends JQGridConverter
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
        $id = $this->request->get('id');
        $agent = $this->manager->findAgentById($id);

        $serializedObj = FSDSerializer::serialize($agent);

        $this->request->attributes->set($this->param, new ArrayCollection(array($serializedObj)));

    }

}