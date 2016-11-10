<?php

namespace UserBundle\Adapter;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class UserAdapterUtil
 * @package UserBundle\Adapter
 */
abstract class UserAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';
    const USER_CLASS          = 'User';
    /** parameters for user entity */
    const USER_JQGRID_CONVERTER = 'userJqgrid';
    const USER_SAVE_CONVERTER   = 'userSave';

}