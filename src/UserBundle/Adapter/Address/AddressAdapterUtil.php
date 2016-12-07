<?php

namespace UserBundle\Adapter\Address;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class ImageAdapterUtil
 * @package UserBundle\Adapter
 */
abstract class AddressAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';
    const ADDRESS_CLASS          = 'Address';
    /** parameters for user entity */
    const ADDRESS_SAVE_CONVERTER   = 'addressSave';

}