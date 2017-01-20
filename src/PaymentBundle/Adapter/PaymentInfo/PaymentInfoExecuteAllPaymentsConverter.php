<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BasicConverter;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PaymentInfoExecuteAllPaymentsConverter
 * @package PaymentBundle\Adapter\PaymentInfo
 */
class PaymentInfoExecuteAllPaymentsConverter extends BasicConverter
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
        $ns = $this->request->request->get('newState');

        $newState = $ns === 'true' ? true : ($ns==='false' ? false : null);

        $this->request->attributes->set($this->param, $this->manager->executeAllPayments($newState));
    }

}