<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PaymentInfoCreateConverter
 * @package PaymentBundle\Adapter\PaymentInfo
 */
class PaymentInfoCreateConverter extends BasicConverter
{
    /**
     * @param PaymentInfoManager $manager
     * @param Request            $request
     * @param string             $param
     */
    public function __construct(PaymentInfoManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $data = json_decode($this->request->getContent());

        $payments = $this->manager->calculateCommissions(
            (int) $data->agentId,
            (float) $data->sumPackages,
            (float) $data->sumConnect,
            (float) $data->sumOneTimeSetupFee,
            (float) $data->sumStreams,
            (int) $data->customerId,
            (int) $data->orderId,
            $data->currency,
            $data->customersInAYear
        );

        if ($payments) {
            $this->request->attributes->set($this->param, new ArrayCollection(['code' => 200]));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(['code' => 500]));
        }
    }

}