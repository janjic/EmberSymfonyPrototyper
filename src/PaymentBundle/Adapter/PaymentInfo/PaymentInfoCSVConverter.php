<?php

namespace PaymentBundle\Adapter\PaymentInfo;

use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PaymentInfoCSVConverter
 * @package PaymentBundle\Adapter\PaymentInfo
 */
class PaymentInfoCSVConverter extends BasicConverter
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
        $fromState = $this->request->get('fromState');
        $fromState = $fromState === 'true' ? true : ($fromState==='false' ? false : ($fromState==='null' ? null : ''));

        $agent     = ($ag = $this->request->get('agent')) ? $ag : null;
        $endDate   = ($ed = $this->request->get('endDate')) ? $ed : null;
        $startDate = ($sd = $this->request->get('startDate')) ? $sd : null;
        $type      = ($t = $this->request->get('type')) ? $t : null;
        $country   = ($c = $this->request->get('country')) ? $c : null;

        $this->request->attributes->set($this->param, new ArrayCollection([
            $this->manager->exportToCSV($fromState, $agent, $startDate, $endDate, $type, $country)
        ]));
    }
}