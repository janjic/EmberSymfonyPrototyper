<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class AgentAdapterUtil
 * @package UserBundle\Adapter\Group
 */
abstract class AgentAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    const GROUP_EDIT_CONVERTER       = 'agentAPI';
    const AGENT_ORGCHART_CONVERTER   = 'agentOrgchart';
    const AGENT_BY_COUNTRY_CONVERTER = 'agentsByCountry';

}