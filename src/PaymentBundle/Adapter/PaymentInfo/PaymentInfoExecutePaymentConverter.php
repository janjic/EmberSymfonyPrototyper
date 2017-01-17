<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PaymentInfoExecutePaymentConverter
 * @package PaymentBundle\Adapter\PaymentInfo
 */
class PaymentInfoExecutePaymentConverter extends BasicConverter
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
        $paymentId = $this->request->request->get('paymentId');
        $newState = $this->request->request->get('newState') === 'true' ? true : false;

        $payment = $this->manager->findPayment($paymentId);

        $this->request->attributes->set($this->param, $this->manager->executePayment($payment, $newState));
    }

}