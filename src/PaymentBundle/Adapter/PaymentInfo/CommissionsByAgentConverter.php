<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommissionsByAgentConverter
 * @package PaymentBundle\Adapter\PaymentInfo
 */
class CommissionsByAgentConverter extends BasicConverter
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
        $agentId = $this->request->request->get('agentId');
        $currency = $this->request->request->get('currency');
        $data = $this->manager->getCommissionsByAgent($currency, $agentId);
        $this->request->attributes->set($this->param, new ArrayCollection($data));
    }

}