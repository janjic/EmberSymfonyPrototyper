<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PaymentInfoEarningsByAgentConverter
 * @package PaymentBundle\Adapter\PaymentInfo
 */
class PaymentInfoEarningsByAgentConverter extends BasicConverter
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
        $currency = $this->request->get('currency');

        $dateFrom = $this->request->get('dateFrom');
        $dateTo   = $this->request->get('dateTo');

        $agent = $this->manager->getUser();

        $data = $this->manager->getEarningsForAgent($agent, $currency, $dateFrom, $dateTo);

        $this->request->attributes->set($this->param, new ArrayCollection($data));
    }

}