<?php

namespace UserBundle\Adapter\AgentHistory;

use CoreBundle\Adapter\JsonAPIConverter;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentHistoryManager;

/**
 * Class AgentHistoryAPIConverter
 * @package UserBundle\Adapter\AgentHistory
 *
 */
class AgentHistoryAPIConverter extends JsonAPIConverter
{
    /**
     * @param AgentHistoryManager $manager
     * @param Request             $request
     * @param string              $param
     */
    public function __construct(AgentHistoryManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, parent::convert());
    }

}