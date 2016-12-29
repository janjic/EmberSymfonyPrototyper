<?php

namespace PaymentBundle\Business\Manager;

use PaymentBundle\Business\Repository\PaymentInfoRepository;
use PaymentBundle\Entity\PaymentInfo;
use UserBundle\Business\Manager\Agent\RoleCheckerTrait;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Entity\Agent;

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
     */
    public function calculateCommissions($agentId, $packagesPrice, $connectPrice, $setupFeePrice, $streamPrice)
    {
        /** @var Agent $agent */
        $agent = $this->agentManager->findAgentById($agentId);



        if ($this->isReferee($agent)) {
            // proveri da li je prva prodaja za toga agenta i klijenta

            // ako jeste prva prodaja dodaj novi paymentInfo

            // ako nije ignorisi
        } else {

            return $this->createCommissionForAgent();
        }
    }

    /**
     * @param Agent $agent
     * @param $packagesPrice
     * @param $connectPrice
     * @param $setupFeePrice
     * @param $streamPrice
     * @return array
     */
    public function createCommissionForAgent($agent, $packagesPrice, $connectPrice, $setupFeePrice, $streamPrice)
    {
        if ($this->isHQ($agent->getSuperior())) {
            $payment = new PaymentInfo();
            $payment->setAgent($agent);
            $payment->setPackagesValue($packagesPrice)->setConnectValue($connectPrice);
            $payment->setSetupFeeValue($setupFeePrice)->setStreamValue($streamPrice);


            $payment->setPackagesPercentage(5+2.5+1.25)->setConnectPercentage(5+2.5+1.25);
            $payment->setSetupFeePercentage(5+2.5+1.25)->setStreamPercentage(5+2.5+1.25);

            $payment->calculateCommissions();

            return [$payment];
        } else {
            // the have same role
            if ($agent->getRoles()[0] == $agent->getSuperior()->getRoles()[0]) {
                $payment = new PaymentInfo();
                $payment->setAgent($agent);
                $payment->setPackagesValue($packagesPrice)->setConnectValue($connectPrice);
                $payment->setSetupFeeValue($setupFeePrice)->setStreamValue($streamPrice);


                $payment->setPackagesPercentage(5+2.5)->setConnectPercentage(5+2.5);
                $payment->setSetupFeePercentage(5+2.5)->setStreamPercentage(5+2.5);

                $payment->calculateCommissions();

                if ($agent->getSuperior()->getSuperior()) {
                    return array_push($this->createCommissionForAgent($agent->getSuperior()->getSuperior(),
                        $packagesPrice, $connectPrice, $setupFeePrice, $streamPrice), $payment);
                } else {
//                    return
                }
            } else {

            }
        }

        // nije - 5%
        // da li mu je roditel istog tipa
        // jeste - preskoci roditelja
        // nije - predi na rodielja
    }

}