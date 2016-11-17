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

    /** parameters for user entity */
    const GROUP_SAVE_CONVERTER = 'agentSave';
    const GROUP_EDIT_CONVERTER = 'agentEdit';

}