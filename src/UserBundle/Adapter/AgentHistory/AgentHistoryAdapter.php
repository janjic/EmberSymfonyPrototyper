<?php

namespace UserBundle\Adapter\AgentHistory;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentHistoryManager;

/**
 * Class AgentHistoryAdapter
 * @package UserBundle\Adapter\AgentHistory
 */
class AgentHistoryAdapter extends BaseAdapter
{
    /**
     * @param AgentHistoryManager $agentHistoryManager
     */
    public function __construct(AgentHistoryManager $agentHistoryManager)
    {
        $this->agentHistoryManager = $agentHistoryManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).AgentHistoryAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->agentHistoryManager, $request, $param);
    }
}