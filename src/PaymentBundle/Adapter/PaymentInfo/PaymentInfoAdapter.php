<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PaymentInfoAdapter
 * @package PaymentBundle\Adapter\PaymentInfo
 */
class PaymentInfoAdapter extends BaseAdapter
{
    /**
     * @var PaymentInfoManager
     */
    protected $paymentInfoManager;

    /**
     * @param PaymentInfoManager $paymentInfoManager
     */
    public function __construct(PaymentInfoManager $paymentInfoManager)
    {
        $this->paymentInfoManager = $paymentInfoManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).PaymentInfoAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->paymentInfoManager, $request, $param);
    }
}