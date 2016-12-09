<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;

/**
 * Class AgentAdapter
 * @package UserBundle\Adapter\Agent
 */
class AgentAdapter extends BaseAdapter
{
    /**
     * @param AgentManager $agentManager
     */
    public function __construct(AgentManager $agentManager)
    {
        $this->agentManager = $agentManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).AgentAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->agentManager, $request, $param);
    }
}