<?php

namespace PaymentBundle\Business\Manager\Payment;

use ConversationBundle\Business\Event\Thread\ThreadEvents;
use ConversationBundle\Business\Event\Thread\ThreadReadEvent;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Adapter\AgentApiResponse;
use Exception;
use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\MessageBuilder\NewThreadMessageBuilder;
use FOS\MessageBundle\MessageBuilder\ReplyMessageBuilder;
use FOS\MessageBundle\Model\MessageInterface;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use PaymentBundle\Entity\PaymentInfo;
use UserBundle\Business\Event\Notification\NotificationEvent;
use UserBundle\Business\Event\Notification\NotificationEvents;
use UserBundle\Business\Manager\NotificationManager;
use UserBundle\Business\Manager\RoleManager;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;
use UserBundle\Entity\Settings\Commission;

/**
 * Class PaymentInfoCreationTrait
 * @package PaymentBundle\Business\Manager\Payment
 */
trait PaymentInfoCreationTrait
{
    /**
     * @param int    $agentId
     * @param float  $packagesPrice
     * @param float  $connectPrice
     * @param float  $setupFeePrice
     * @param float  $streamPrice
     * @param int    $customerId
     * @param int    $orderId
     * @param string $currency
     * @return array
     */
    public function calculateCommissions($agentId, $packagesPrice, $connectPrice, $setupFeePrice, $streamPrice, $customerId, $orderId, $currency)
    {
        $this->packagesPrice = $packagesPrice;
        $this->connectPrice  = $connectPrice;
        $this->setupFeePrice = $setupFeePrice;
        $this->streamPrice   = $streamPrice;
        $this->customerId    = $customerId;
        $this->orderId       = $orderId;
        $this->currency      = $currency;

        /** @var Agent $agent */
        $agent = $this->agentManager->findAgentById($agentId);
        if ($this->isHQ($agent)) {
            /** HQ has no commissions */
            $payments = [];
        } else if ($this->isReferee($agent)) {
            /** Referee gets commission only first time client purchases */
            if (sizeof($this->getPaymentInfoForAgent($agent, $customerId)) === 0 ) {
                $commission = $this->commissionManager->getCommissionForGroup($agent->getGroup());
                $payments = [$this->createPaymentInfo($agent, $commission->getPackages(), $commission->getConnect(),
                    $commission->getSetupFee(), $commission->getStream())];
            } else {
                $payments = [];
            }
        } else {
            $payments = $this->createCommissionForAgent($agent);
        }

        $payments = $this->repository->saveArray($payments);

        return $this->serializePaymentInfo($payments);
    }

    /**
     * @param Agent $agent
     * @return array
     */
    public function createCommissionForAgent($agent)
    {
        /** @var Commission $commissionAA */
        $commissionAA = $this->commissionManager->getCommissionForRole(RoleManager::ROLE_ACTIVE_AGENT);
        $payments = [$this->createPaymentInfo($agent, $commissionAA->getPackages(), $commissionAA->getConnect(),
            $commissionAA->getSetupFee(), $commissionAA->getStream())];

        /** if parent is hq all payments are done */
        if ($this->isHQ($agent->getSuperior())) {
            return $payments;
        }

        if ($this->isAmbassador($agent->getSuperior())) {
            /** @var Commission $commissionMA */
            $commissionMA = $this->commissionManager->getCommissionForRole(RoleManager::ROLE_MASTER_AGENT);
            array_push($payments, $this->createPaymentInfo($agent->getSuperior(), $commissionMA->getPackages(), $commissionMA->getConnect(),
                $commissionMA->getSetupFee(), $commissionMA->getStream()));

            return $payments;
        }

        if ($this->isActiveAgent($agent->getSuperior()) && ($ambassador = $this->getAmbassador($agent))) {

            /** @var Commission $commissionA */
            $commissionA  = $this->commissionManager->getCommissionForRole(RoleManager::ROLE_AMBASSADOR);
            array_push($payments, $this->createPaymentInfo($ambassador, $commissionA->getPackages(), $commissionA->getConnect(),
                $commissionA->getSetupFee(), $commissionA->getStream()));

            return $payments;
        }

        /** if it comes to here agent's superior is master agent */
        $master = $agent->getSuperior();
        /** @var Commission $commissionMA */
        $commissionMA = $this->commissionManager->getCommissionForRole(RoleManager::ROLE_MASTER_AGENT);
        array_push($payments, $this->createPaymentInfo($master, $commissionMA->getPackages(), $commissionMA->getConnect(),
            $commissionMA->getSetupFee(), $commissionMA->getStream()));

        if (($ambassador = $this->getAmbassador($agent))) {
            /** @var Commission $commissionA */
            $commissionA  = $this->commissionManager->getCommissionForRole(RoleManager::ROLE_AMBASSADOR);
            array_push($payments, $this->createPaymentInfo($ambassador, $commissionA->getPackages(), $commissionA->getConnect(),
                $commissionA->getSetupFee(), $commissionA->getStream()));

        }

        return $payments;
    }

    /**
     * @param Agent $agent
     * @return null|Agent
     */
    public function getAmbassador(Agent $agent) {
        $superior = $agent->getSuperior();
        if (!$superior) {
            return null;
        }

        if ($this->isAmbassador($superior)) {
            return $superior;
        }

        return $this->getAmbassador($superior);
    }


//    /**
//     * @param int    $agentId
//     * @param float  $packagesPrice
//     * @param float  $connectPrice
//     * @param float  $setupFeePrice
//     * @param float  $streamPrice
//     * @param int    $customerId
//     * @param int    $orderId
//     * @param string $currency
//     * @return array
//     */
//    public function calculateCommissions($agentId, $packagesPrice, $connectPrice, $setupFeePrice, $streamPrice, $customerId, $orderId, $currency)
//    {
//        $this->packagesPrice = $packagesPrice;
//        $this->connectPrice  = $connectPrice;
//        $this->setupFeePrice = $setupFeePrice;
//        $this->streamPrice   = $streamPrice;
//        $this->customerId    = $customerId;
//        $this->orderId       = $orderId;
//        $this->currency      = $currency;
//
//        /** @var Agent $agent */
//        $agent = $this->agentManager->findAgentById($agentId);
//        if ($this->isHQ($agent)) {
//            /** HQ has no commissions */
//            $payments = [];
//        } else if ($this->isReferee($agent)) {
//            /** Referee gets commission only first time client purchases */
//            if (sizeof($this->getPaymentInfoForAgent($agent, $customerId)) === 0 ) {
//                $commission = $this->commissionManager->getCommissionForGroup($agent->getGroup());
//                $payments = [$this->createPaymentInfo($agent, $commission->getPackages(), $commission->getConnect(),
//                    $commission->getSetupFee(), $commission->getStream())];
//            } else {
//                $payments = [];
//            }
//        } else {
//            $payments = $this->createCommissionForAgent($agent);
//        }
//
//        $payments = $this->repository->saveArray($payments);
//
//        return $this->serializePaymentInfo($payments);
//    }
//
//    /**
//     * @param Agent $agent
//     * @param int   $commissionsPayed
//     * @return array
//     */
//    public function createCommissionForAgent($agent, $commissionsPayed = 0)
//    {
//        /** get settings from db */
//        /** @var Commission $commissionAA */
//        $commissionAA = $this->commissionManager->getCommissionForRole(RoleManager::ROLE_ACTIVE_AGENT);
//        /** @var Commission $commissionMA */
//        $commissionMA = $this->commissionManager->getCommissionForRole(RoleManager::ROLE_MASTER_AGENT);
//        /** @var Commission $commissionA */
//        $commissionA  = $this->commissionManager->getCommissionForRole(RoleManager::ROLE_AMBASSADOR);
//
//        /** set initial percentages */
//        $totalPackagesCommissionPercentage = $commissionsPayed == 0 ? $commissionAA->getPackages() : $commissionMA->getPackages();
//        $totalConnectCommissionPercentage  = $commissionsPayed == 0 ? $commissionAA->getConnect()  : $commissionMA->getConnect();
//        $totalSetupFeeCommissionPercentage = $commissionsPayed == 0 ? $commissionAA->getSetupFee() : $commissionMA->getSetupFee();
//        $totalStreamCommissionPercentage   = $commissionsPayed == 0 ? $commissionAA->getStream()   : $commissionMA->getStream();
//
//        /** @var Agent $parent */
//        $parent = $agent->getSuperior();
//        /** get parent that has different role than current agent */
//        while ($this->hasHigherOrSameRole($agent, $parent)) {
//            if ($parent->getSuperior()) {
//                $parent = $parent->getSuperior();
//            } else {
//                break;
//            }
//        }
//
//        if ($this->isHQ($parent)) {
//            /** if parent is hq agent is ambassador  */
//            if ($commissionsPayed == 0) {
//                if ($this->isMasterAgent($agent)) {
//                    /** Master agent has sold package but his parent is HQ */
//                    $totalPackagesCommissionPercentage += $commissionMA->getPackages();
//                    $totalConnectCommissionPercentage  += $commissionMA->getConnect();
//                    $totalSetupFeeCommissionPercentage += $commissionMA->getSetupFee();
//                    $totalStreamCommissionPercentage   += $commissionMA->getStream();
//                } else if ($this->isAmbassador($agent)) {
//                    /** Ambassador has sold package */
//                    $totalPackagesCommissionPercentage += $commissionMA->getPackages() + $commissionA->getPackages();
//                    $totalConnectCommissionPercentage  += $commissionMA->getConnect() + $commissionA->getConnect();
//                    $totalSetupFeeCommissionPercentage += $commissionMA->getSetupFee() + $commissionA->getSetupFee();
//                    $totalStreamCommissionPercentage   += $commissionMA->getStream() + $commissionA->getStream();
//                }
//            } else {
//                if ($this->isMasterAgent($agent)) {
//                    /** Master agent gets standard commission */
//                    $totalPackagesCommissionPercentage = $commissionMA->getPackages();
//                    $totalConnectCommissionPercentage  = $commissionMA->getConnect();
//                    $totalSetupFeeCommissionPercentage = $commissionMA->getSetupFee();
//                    $totalStreamCommissionPercentage   = $commissionMA->getStream();
//                } else if ($this->isAmbassador($agent)) {
//                    /** Ambassador gets standard commission */
//                    $totalPackagesCommissionPercentage = $commissionA->getPackages();
//                    $totalConnectCommissionPercentage  = $commissionA->getConnect();
//                    $totalSetupFeeCommissionPercentage = $commissionA->getSetupFee();
//                    $totalStreamCommissionPercentage   = $commissionA->getStream();
//                }
//
//
//            }
//
//            return [$this->createPaymentInfo($agent, $totalPackagesCommissionPercentage, $totalConnectCommissionPercentage,
//                $totalSetupFeeCommissionPercentage, $totalStreamCommissionPercentage)];
//        }
//
//        $payments = $this->createCommissionForAgent($parent, ++$commissionsPayed);
//
//        if ($commissionsPayed == 1 && sizeof($payments) == 1 && $this->isAmbassador($payments[0]->getAgent())) {
//            /** Parent is ambassador -> agent gets AA and MA commissions */
//            $totalPackagesCommissionPercentage += $commissionMA->getPackages();
//            $totalConnectCommissionPercentage  += $commissionMA->getConnect();
//            $totalSetupFeeCommissionPercentage += $commissionMA->getSetupFee();
//            $totalStreamCommissionPercentage   += $commissionMA->getStream();
//        }
//
//        array_push($payments, $this->createPaymentInfo($agent, $totalPackagesCommissionPercentage, $totalConnectCommissionPercentage,
//            $totalSetupFeeCommissionPercentage, $totalStreamCommissionPercentage));
//
//        return $payments;
//    }

    /**
     * @param Agent $agent
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

        $payment->setOrderId($this->orderId)->setCustomerId($this->customerId);
        $payment->setPaymentType(PaymentInfoManager::COMMISSION_TYPE);
        $payment->setAgentRole($agent->getGroup()->getName());
        $payment->setCurrency($this->currency);

        return $payment;
    }
}