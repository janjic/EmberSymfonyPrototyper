<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BonusesByAgentConverter
 * @package PaymentBundle\Adapter\PaymentInfo
 */
class BonusesByAgentConverter extends BasicConverter
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
        $data = $this->manager->getBonusesByAgent($currency);
        $this->request->attributes->set($this->param, new ArrayCollection($data));
    }

}