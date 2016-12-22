<?php

namespace UserBundle\Adapter\AgentHistory;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class AgentHistoryAdapterUtil
 * @package UserBundle\Adapter\AgentHistory
 */
abstract class AgentHistoryAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    const AGENT_HISTORY_CONVERTER = 'agentHistoryAPI';

}