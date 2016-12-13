<?php

namespace UserBundle\Adapter\TCRUser;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class TCRUserAdapterUtil
 * @package UserBundle\Adapter\TCRUser
 */
abstract class TCRUserAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const TCR_USER_API = 'tCRUserAPI';
}