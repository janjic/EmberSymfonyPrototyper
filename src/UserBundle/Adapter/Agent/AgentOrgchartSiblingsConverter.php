<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;

/**
 * Class AgentOrgchartSiblingsConverter
 * @package UserBundle\Adapter\Agent
 */
class AgentOrgchartSiblingsConverter extends JsonAPIConverter
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

        $data = $this->manager->loadOrgchartSiblings($this->request->get('id'));

        $this->request->attributes->set($this->param, new ArrayCollection($data));

    }

}