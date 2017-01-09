<?php

namespace PaymentBundle\Business\Manager;

use PaymentBundle\Business\Repository\PaymentInfoRepository;
use PaymentBundle\Entity\PaymentInfo;
use UserBundle\Business\Manager\Agent\RoleCheckerTrait;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Entity\Agent;
use Doctrine\Common\Util\Debug;

/**
 * Class PaymentInfoManager
 * @package PaymentBundle\Business\Manager
 */
class PaymentInfoManager
{
    use RoleCheckerTrait;

    /**
     * @var PaymentInfoRepository
     */
    protected $repository;

    /**
     * @var AgentManager
     */
    protected $agentManager;

    protected $packagesPrice;
    protected $connectPrice;
    protected $setupFeePrice;
    protected $streamPrice;


    /**
     * @param PaymentInfoRepository $repository
     * @param AgentManager          $agentManager
     */
    public function __construct(PaymentInfoRepository $repository, AgentManager $agentManager)
    {
        $this->repository   = $repository;
        $this->agentManager = $agentManager;
    }

    /**
     * @param int   $agentId
     * @param float $packagesPrice
     * @param float $connectPrice
     * @param float $setupFeePrice
     * @param float $streamPrice
     * @return array
     */
    public function calculateCommissions($agentId, $packagesPrice, $connectPrice, $setupFeePrice, $streamPrice)
    {
        $this->packagesPrice = $packagesPrice;
        $this->connectPrice  = $connectPrice;
        $this->setupFeePrice = $setupFeePrice;
        $this->streamPrice   = $streamPrice;


        /** @var Agent $agent */
        $agent = $this->agentManager->findAgentById($agentId);

        if ($this->isReferee($agent)) {
            // proveri da li je placen pre!

            return [$this->createPaymentInfo($agent, 5, 5, 5, 5)];

        } else {
            return $this->createCommissionForAgent($agent);
        }
    }

    /**
     * @param Agent $agent
     * @param int   $commissionsPayed
     * @return array
     */
    public function createCommissionForAgent($agent, $commissionsPayed = 0)
    {
        $totalPackagesCommissionPercentage = $commissionsPayed == 0 ? 5 : ($commissionsPayed == 1 ? 2.5 : 1.25);
        $totalConnectCommissionPercentage  = $commissionsPayed == 0 ? 5 : ($commissionsPayed == 1 ? 2.5 : 1.25);
        $totalSetupFeeCommissionPercentage = $commissionsPayed == 0 ? 5 : ($commissionsPayed == 1 ? 2.5 : 1.25);
        $totalStreamCommissionPercentage   = $commissionsPayed == 0 ? 5 : ($commissionsPayed == 1 ? 2.5 : 1.25);

        /** @var Agent $parent */
        $parent = $agent->getSuperior();
        while ($this->hasHigherOrSameRole($agent, $parent)) {
            if ($parent->getSuperior()) {
                $parent = $parent->getSuperior();
            } else {
                break;
            }
        }

        if ($this->isHQ($parent)) {
            if ($commissionsPayed == 0) {
                /** Ambassador has sold package */
                $totalPackagesCommissionPercentage += 2.5 + 1.25;
                $totalConnectCommissionPercentage += 2.5 + 1.25;
                $totalSetupFeeCommissionPercentage += 2.5 + 1.25;
                $totalStreamCommissionPercentage += 2.5 + 1.25;
            } else {
                /** Ambassador gets standard commission */
                $totalPackagesCommissionPercentage = 1.25;
                $totalConnectCommissionPercentage = 1.25;
                $totalSetupFeeCommissionPercentage = 1.25;
                $totalStreamCommissionPercentage = 1.25;
            }

            return [$this->createPaymentInfo($agent, $totalPackagesCommissionPercentage, $totalConnectCommissionPercentage,
                $totalSetupFeeCommissionPercentage, $totalStreamCommissionPercentage)];
        }

        $payments = $this->createCommissionForAgent($parent, ++$commissionsPayed);

        if ($commissionsPayed == 1 && sizeof($payments) == 1 && $this->isAmbassador($payments[0]->getAgent())) {
            /** Parent is ambassador -> agent gets AA and MA commissions */
            $totalPackagesCommissionPercentage += 2.5;
            $totalConnectCommissionPercentage += 2.5;
            $totalSetupFeeCommissionPercentage += 2.5;
            $totalStreamCommissionPercentage += 2.5;
        }

        array_push($payments, $this->createPaymentInfo($agent, $totalPackagesCommissionPercentage, $totalConnectCommissionPercentage,
            $totalSetupFeeCommissionPercentage, $totalStreamCommissionPercentage));

        return $payments;
    }

    /**
     * @param $agent
     * @param $totalPackagesCommissionPercentage
     * @param $totalConnectCommissionPercentage
     * @param $totalSetupFeeCommissionPercentage
     * @param $totalStreamCommissionPercentage
     * @return PaymentInfo
     */
    public function createPaymentInfo($agent, $totalPackagesCommissionPercentage, $totalConnectCommissionPercentage,
                                      $totalSetupFeeCommissionPercentage, $totalStreamCommissionPercentage) {
        $payment = new PaymentInfo();
        $payment->setAgent($agent);
        $payment->setPackagesValue($this->packagesPrice)->setConnectValue($this->connectPrice);
        $payment->setSetupFeeValue($this->setupFeePrice)->setStreamValue($this->streamPrice);

        $payment->setPackagesPercentage($totalPackagesCommissionPercentage)->setConnectPercentage($totalConnectCommissionPercentage);
        $payment->setSetupFeePercentage($totalSetupFeeCommissionPercentage)->setStreamPercentage($totalStreamCommissionPercentage);

        $payment->calculateCommissions();

        return $payment;
    }

}