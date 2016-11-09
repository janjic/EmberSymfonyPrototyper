<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class RoleAdapterUtil
 * @package UserBundle\Adapter\Role
 */
abstract class RoleAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const ROLE_ALL_CONVERTER = 'roleGetAll';
    const ROLE_ADD_CONVERTER = 'roleAdd';
    const ROLE_DELETE_CONVERTER = 'roleDelete';

}