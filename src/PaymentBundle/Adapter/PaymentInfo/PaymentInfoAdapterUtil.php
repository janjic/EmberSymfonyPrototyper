<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class PaymentInfoAdapterUtil
 * @package PaymentBundle\Adapter\PaymentInfo
 */
abstract class PaymentInfoAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    const PAYMENT_INFO_CREATE_CONVERTER = 'paymentInfoCreate';
    const PAYMENT_INFO_API_CONVERTER    = 'paymentInfoAPI';

}