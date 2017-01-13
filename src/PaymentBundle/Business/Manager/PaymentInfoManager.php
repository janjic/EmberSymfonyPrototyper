<?php

namespace PaymentBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use PaymentBundle\Business\Manager\Payment\PaymentInfoCreationTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoGetTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoJQGridTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoSerializationTrait;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use PaymentBundle\Business\Repository\PaymentInfoRepository;
use Swap\Model\CurrencyPair;
use Swap\Swap;
use UserBundle\Business\Manager\Agent\RoleCheckerTrait;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Business\Manager\CommissionManager;
use UserBundle\Entity\Agent;

/**
 * Class PaymentInfoManager
 * @package PaymentBundle\Business\Manager
 */
class PaymentInfoManager implements JSONAPIEntityManagerInterface
{
    use RoleCheckerTrait;
    use PaymentInfoSerializationTrait;
    use PaymentInfoCreationTrait;
    use PaymentInfoGetTrait;
    use PaymentInfoJQGridTrait;

    const COMMISSION_TYPE = 'COMMISSION_TYPE';
    const BONUS_TYPE      = 'BONUS_TYPE';

    /**
     * @var PaymentInfoRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @var CommissionManager $commissionManager
     */
    protected $commissionManager;

    /**
     * @var AgentManager
     */
    protected $agentManager;

    protected $packagesPrice;
    protected $connectPrice;
    protected $setupFeePrice;
    protected $streamPrice;
    protected $customerId;
    protected $orderId;
    protected $currency;
    protected $florianSwap;
    protected $tokenStorage;

    /**
     * @param PaymentInfoRepository $repository
     * @param AgentManager $agentManager
     * @param FJsonApiSerializer $fSerializer
     * @param CommissionManager $commissionManager
     * @param Swap $florianSwap
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(PaymentInfoRepository $repository, AgentManager $agentManager, FJsonApiSerializer $fSerializer, CommissionManager $commissionManager, Swap $florianSwap, TokenStorageInterface $tokenStorage)
    {
        $this->repository        = $repository;
        $this->agentManager      = $agentManager;
        $this->fSerializer       = $fSerializer;
        $this->commissionManager = $commissionManager;
        $this->florianSwap       = $florianSwap;
        $this->tokenStorage      = $tokenStorage;
    }

    /**
     * @param Agent $agent
     * @param null|int $customerId
     * @return array
     */
    public function getPaymentInfoForAgent($agent, $customerId = null)
    {
        return $this->repository->getPaymentInfoForAgent($agent, $customerId);
    }

    /**
     * @param $currency
     * @return mixed
     */
    public function getCommissionsByAgent($currency)
    {
        $agent = $this->tokenStorage->getToken()->getUser();
        if($currency == 'EUR'){
            $ratio = $this->florianSwap->quote(new CurrencyPair('EUR', 'CHF'));
        } else {
            $ratio = $this->florianSwap->quote(new CurrencyPair('CHF', 'EUR'));
        }

        return $this->repository->getCommissionsByAgent($currency, $ratio, $agent);
    }

    /**
     * @param $currency
     * @return mixed
     */
    public function getBonusesByAgent($currency)
    {
        if($currency == 'EUR'){
            $ratio = $this->florianSwap->quote(new CurrencyPair('EUR', 'CHF'));
        } else {
            $ratio = $this->florianSwap->quote(new CurrencyPair('CHF', 'EUR'));
        }

        return $this->repository->getBonusesByAgent($currency, $ratio);
    }


    public function saveResource($data)
    {
        // TODO: Implement saveResource() method.
    }

    public function updateResource($data)
    {
        // TODO: Implement updateResource() method.
    }

    public function deleteResource($id)
    {
        // TODO: Implement deleteResource() method.
    }


}