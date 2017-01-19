<?php

namespace PaymentBundle\Business\Manager;

use CoreBundle\Adapter\AgentApiResponse;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use FSerializerBundle\services\FJsonApiSerializer;
use PaymentBundle\Business\Manager\Payment\PaymentInfoCreationTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoGetTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoJQGridTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoSerializationTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoUpdateTrait;
use PaymentBundle\Business\Manager\Payment\PromotionSuggestionJQGridTrait;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use PaymentBundle\Business\Repository\PaymentInfoRepository;
use PaymentBundle\Entity\PaymentInfo;
use Swap\Model\CurrencyPair;
use Swap\Swap;
use UserBundle\Business\Manager\Agent\RoleCheckerTrait;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Business\Manager\BonusManager;
use UserBundle\Business\Manager\CommissionManager;
use UserBundle\Business\Manager\GroupManager;
use UserBundle\Business\Manager\RoleManager;
use UserBundle\Entity\Agent;
use UserBundle\Helpers\RoleHelper;

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
    use PromotionSuggestionJQGridTrait;
    use PaymentInfoUpdateTrait;

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
    /**
     * @var GroupManager
     */
    protected $groupManager;

    /**
     * @var Swap
     */
    protected $florianSwap;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var BonusManager
     */
    protected $bonusManager;

    protected $packagesPrice;
    protected $connectPrice;
    protected $setupFeePrice;
    protected $streamPrice;
    protected $customerId;
    protected $orderId;
    protected $currency;

    /**
     * @param PaymentInfoRepository $repository
     * @param AgentManager $agentManager
     * @param FJsonApiSerializer $fSerializer
     * @param CommissionManager $commissionManager
     * @param Swap $florianSwap
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(PaymentInfoRepository $repository, AgentManager $agentManager, FJsonApiSerializer $fSerializer, CommissionManager $commissionManager, Swap $florianSwap, TokenStorageInterface $tokenStorage, GroupManager $groupManager, BonusManager $bonusManager)
    {
        $this->repository        = $repository;
        $this->agentManager      = $agentManager;
        $this->fSerializer       = $fSerializer;
        $this->commissionManager = $commissionManager;
        $this->florianSwap       = $florianSwap;
        $this->tokenStorage      = $tokenStorage;
        $this->groupManager      = $groupManager;
        $this->bonusManager      = $bonusManager;
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
     * @return mixed
     */
    public function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
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

    public function deleteResource($id)
    {
        // TODO: Implement deleteResource() method.
    }

    public function findPayment($id)
    {
        return $this->repository->findPayment($id);
    }

    /**
     * @param $superAdminId
     * @return array
     */
    public function newCommissionsCount($superAdminId)
    {
        $agent = $this->tokenStorage->getToken()->getUser();
        $agent = $superAdminId == $agent->getId() ? null : $agent;

        $today = $this->repository->newCommissionsCount($agent, 'today');
        $month = $this->repository->newCommissionsCount($agent, 'month');
        $total = $this->repository->newCommissionsCount($agent, 'total');
        $totalInfo = array();

        for ($itt = 0; $itt < count($total); $itt++){
            $totalInfo[$total[$itt]['currency']]['currency']       = $total[$itt]['currency'];

            $totalInfo[$total[$itt]['currency']]['total']          = $total[$itt]['total_commission_sum'];
            if ( $month[$itt]['currency'] ) {
                $totalInfo[$month[$itt]['currency']]['this_month'] = $month[$itt]['total_commission_sum'];
            }
            if ( $today[$itt]['currency'] ) {
                $totalInfo[$today[$itt]['currency']]['today']      = $today[$itt]['total_commission_sum'];
            }
        }

        return $totalInfo;
    }

    /**
     * @param PaymentInfo $paymentInfo
     * @param boolean $newState
     * @return mixed
     */
    public function executePayment($paymentInfo, $newState)
    {
        $paymentInfo->setState($newState);
        $paymentInfo->setPayedAt(new \DateTime());

        return $this->createPaymentExecuteResponse($this->repository->edit($paymentInfo));
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createPaymentExecuteResponse($data)
    {
        switch (get_class($data)) {
            case Exception::class:
                return new ArrayCollection(AgentApiResponse::PAYMENT_EXECUTE_ERROR);
            case (PaymentInfo::class && ($id = $data->getId())):
                return new ArrayCollection(AgentApiResponse::PAYMENT_EXECUTED_SUCCESSFULLY($id));
            default:
                return false;
        }
    }

    /**
     * @param Agent  $agent
     * @param string $currency
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getEarningsForAgent(Agent $agent, $currency, $dateFrom, $dateTo)
    {
        $pair = $currency == 'EUR' ? new CurrencyPair('EUR', 'CHF') : new CurrencyPair('CHF', 'EUR');
        $ratio = $this->florianSwap->quote($pair);

        return $this->repository->getEarningsForAgent($agent, $currency, $ratio, $dateFrom, $dateTo);
    }



    /**
     * @param null $request
     * @return mixed
     */
    public function getPromotionSuggestions($request = null)
    {
        $page = 1;
        if($request){
            $page = $request->get('page');
        }

        if($request && $request->get('type') == 'promotion'){
            $data['promotions'] = array_merge($this->repository->getPromotionSuggestionsForActiveAgent($request, false),$this->repository->getPromotionSuggestionsForReferee($request, false));
        } else if($request && $request->get('type') == 'downgrade') {
            $data['downgrades'] = array_merge($this->repository->getDowngradeSuggestionsForMasterAgent($request, false), $this->repository->getDowngradeSuggestionsForActiveAgent($request, false));
        } else {
            $data['promotions'] = array_merge($this->repository->getPromotionSuggestionsForActiveAgent($request, false),$this->repository->getPromotionSuggestionsForReferee($request, false));
            $data['downgrades'] = array_merge($this->repository->getDowngradeSuggestionsForMasterAgent($request, false), $this->repository->getDowngradeSuggestionsForActiveAgent($request, false));
        }

//        $sizeOfDowngrades = sizeof($this->repository->getDowngradeSuggestionsForMasterAgent($request, true)) +
//        sizeof($this->repository->getDowngradeSuggestionsForActiveAgent($request, true));
//        $pageCount = ceil($sizeOfDowngrades / 10);
//        $data['downgrades']['meta'] = [
//            'totalItems' => $sizeOfDowngrades,
//            'pages' => $pageCount,
//            'page' => $page
//        ];

        $data['role_codes'] = array(
            'role_active_agent' => RoleManager::ROLE_ACTIVE_AGENT,
            'role_master_agent' => RoleManager::ROLE_MASTER_AGENT,
            'role_referee'      => RoleManager::ROLE_REFEREE
        );

        return $data;
    }

    /**
     * @param $agentId
     * @param $superiorId
     */
    public function promoteAgent($agentId, $superiorId)
    {
        /**
         * @var $agent Agent
         */
        $agent = $this->agentManager->findAgentById($agentId);
        if(is_null($superiorId)){
            $group = $this->groupManager->getGroupByName(RoleHelper::PORTAL_MASTER_AGENT);
            $agent->setGroup($group);
        } else {
            $group = $this->groupManager->getGroupByName(RoleHelper::PORTAL_ACTIVE_AGENT);
            $agent->setGroup($group);
            $superior = $this->agentManager->findAgentById($superiorId);
            $agent->setSuperior($superior);
        }

        var_dump($agent->getGroup());exit;
    }

    /**
     * @param $agentId
     * @param $superiorType
     */
    public function demoteAgent($agentId, $superiorType)
    {
        /**
         * @var $agent Agent
         */
        $agent = $this->agentManager->findAgentById($agentId);
        if(is_null($superiorType)){
            $group = $this->groupManager->getGroupByName(RoleHelper::PORTAL_ACTIVE_AGENT);
            $agent->setGroup($group);
        } else {

//            $agent->removeRole(RoleManager::ROLE_ACTIVE_AGENT);
//            $superior = $this->agentManager->findAgentById($superiorId);
//            $agent->setSuperior($superior);
        }

        var_dump($agent->getGroup());exit;
    }
}