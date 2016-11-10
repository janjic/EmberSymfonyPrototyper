<?php

namespace UserBundle\Adapter\Group;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class GroupAdapterUtil
 * @package UserBundle\Adapter\Group
 */
abstract class GroupAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const GROUP_ALL_CONVERTER = 'groupGetAll';
    const GROUP_ADD_CONVERTER = 'groupAdd';
    const GROUP_DELETE_CONVERTER = 'groupDelete';

}