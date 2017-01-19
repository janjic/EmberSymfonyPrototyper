<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;

/**
 * Class PromoteAgentToRoleConverter
 * @package UserBundle\Adapter\Agent
 */
class PromoteAgentToRoleConverter extends JsonAPIConverter
{
    /**
     * @param PaymentInfoManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(PaymentInfoManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $request = $this->request;
        $agentId = $request->get('agent_id');
        $action  = $request->get('action');

        if($action == 'promote'){
            $superiorId = $request->get('superior');
            $this->manager->promoteAgent($agentId, $superiorId);
        } else {
            $superiorType = $request->get('superiorType');
            $this->manager->demoteAgent($agentId, $superiorType);
        }

        $this->request->attributes->set($this->param, new ArrayCollection());
    }

}