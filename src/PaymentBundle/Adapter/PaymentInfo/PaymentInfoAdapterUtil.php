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

    const AGENT_ORGCHART_CONVERTER = 'paymentInfoCreate';

}