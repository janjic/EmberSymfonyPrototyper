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
use UserBundle\Business\Manager\NotificationManager;
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

    /**
     * @var NotificationManager $notificationManager
     */
    protected $notificationManager;

    protected $packagesPrice;
    protected $connectPrice;
    protected $setupFeePrice;
    protected $streamPrice;
    protected $customerId;
    protected $orderId;
    protected $currency;

    /**
     * @param PaymentInfoRepository $repository
     * @param AgentManager          $agentManager
     * @param FJsonApiSerializer    $fSerializer
     * @param CommissionManager     $commissionManager
     * @param Swap                  $florianSwap
     * @param TokenStorageInterface $tokenStorage
     * @param BonusManager          $bonusManager
     */
    public function __construct(PaymentInfoRepository $repository, AgentManager $agentManager, FJsonApiSerializer $fSerializer,
            CommissionManager $commissionManager, Swap $florianSwap, TokenStorageInterface $tokenStorage, GroupManager $groupManager, BonusManager $bonusManager, NotificationManager $notificationManager)
    {
        $this->repository        = $repository;
        $this->agentManager      = $agentManager;
        $this->fSerializer       = $fSerializer;
        $this->commissionManager = $commissionManager;
        $this->florianSwap       = $florianSwap;
        $this->tokenStorage      = $tokenStorage;
        $this->groupManager      = $groupManager;
        $this->bonusManager      = $bonusManager;
        $this->notificationManager = $notificationManager;
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
     * @param boolean|null $newState
     * @return mixed
     */
    public function executeAllPayments($newState)
    {

        $result = $this->repository->changeAllPaymentsState($newState);

        return $this->createPaymentExecuteAllResponse($result);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createPaymentExecuteAllResponse($data)
    {
        if ($data === true) {
            return new ArrayCollection(AgentApiResponse::PAYMENT_EXECUTE_ALL_SUCCESS);
        }

        return new ArrayCollection(AgentApiResponse::PAYMENT_EXECUTE_ALL_ERROR);
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
        $offset = 4;
        if($request){
            $page = intval($request->get('page'));
        }

        if($request && $request->get('type') == 'promotion'){

            $promotionTotalItems = intval(sizeof($this->agentManager->getPromotionSuggestionsForActiveAgent($request, true)) + sizeof($this->agentManager->getPromotionSuggestionsForReferee($request, true)));

            $firstPromotions = $this->agentManager->getPromotionSuggestionsForActiveAgent($request);

            if (($size = sizeof($firstPromotions)) < $offset) {
                if($size != 0){
                    $data['promotions']['data'] = array_merge($firstPromotions,$this->agentManager->getPromotionSuggestionsForReferee($request, false, 0, $offset - $size));
                } else {
                    $totalOfAAPromotions = intval(sizeof($this->agentManager->getPromotionSuggestionsForActiveAgent($request, true)));
                    $pagesOfAA = ceil($totalOfAAPromotions/$offset);
                    $firstResForRef = ($page - $pagesOfAA - 1) * $offset + ($totalOfAAPromotions % $offset);

                    $data['promotions']['data'] = array_merge($firstPromotions,$this->agentManager->getPromotionSuggestionsForReferee($request, false, $firstResForRef, $offset));
                }
            } else {
                $data['promotions']['data'] = array_merge($firstPromotions);
            }

            $data['promotions']['meta'] = array_merge(array('page'=>$page, 'pages' => ceil($promotionTotalItems/$offset), 'totalItems' => $promotionTotalItems));

        } else if($request && $request->get('type') == 'downgrade') {

            $downgradeTotalItems = intval(sizeof($this->agentManager->getDowngradeSuggestionsForMasterAgent($request, true)) + sizeof($this->agentManager->getDowngradeSuggestionsForActiveAgent($request, true)));

            $firstDowngrades = $this->agentManager->getDowngradeSuggestionsForMasterAgent($request);

            if (($size = sizeof($firstDowngrades)) < $offset) {
                if($size != 0){
                    $data['downgrades']['data'] = array_merge($firstDowngrades,$this->agentManager->getDowngradeSuggestionsForActiveAgent($request, false, 0, $offset - $size));
                } else {
                    $totalOfMADowngrades = intval(sizeof($this->agentManager->getDowngradeSuggestionsForMasterAgent($request, true)));
                    $pagesOfMA = ceil($totalOfMADowngrades/$offset);
                    $firstResForRef = ($page - $pagesOfMA - 1) * $offset + ($totalOfMADowngrades % $offset);

                    $data['downgrades']['data'] = array_merge($firstDowngrades,$this->agentManager->getDowngradeSuggestionsForActiveAgent($request, false, $firstResForRef, $offset));
                }

            } else {
                $data['downgrades']['data'] = array_merge($firstDowngrades);
            }

            $data['downgrades']['meta'] = array_merge(array('page'=>$page, 'pages' => ceil($downgradeTotalItems/$offset), 'totalItems' => $downgradeTotalItems));

        } else {
            /**
             * Promotion on first load
             */
            $promotionTotalItems = intval(sizeof($this->agentManager->getPromotionSuggestionsForActiveAgent($request, true)) + sizeof($this->agentManager->getPromotionSuggestionsForReferee($request, true)));
            $firstPromotions = $this->agentManager->getPromotionSuggestionsForActiveAgent($request);

            if (($size = sizeof($firstPromotions)) < $offset) {
                if($size != 0){
                    $data['promotions']['data'] = array_merge($firstPromotions, $this->agentManager->getPromotionSuggestionsForReferee($request, false, 0, $offset - $size));
                } else {
                    $totalOfAAPromotions = intval(sizeof($this->agentManager->getPromotionSuggestionsForActiveAgent($request, true)));
                    $pagesOfAA = ceil($totalOfAAPromotions/$offset);
                    $firstResForRef = ($page - $pagesOfAA - 1) * $offset + ($totalOfAAPromotions % $offset);

                    $data['promotions']['data'] = array_merge($firstPromotions,$this->agentManager->getPromotionSuggestionsForReferee($request, false, $firstResForRef, $offset));
                }

            } else {
                $data['promotions']['data'] = array_merge($firstPromotions);
            }

            $data['promotions']['meta'] = array_merge(array('page'=>$page, 'pages' => ceil($promotionTotalItems/$offset), 'totalItems' => $promotionTotalItems));


            /**
             * Downgrades on first load
             */
            $downgradeTotalItems = intval(sizeof($this->agentManager->getDowngradeSuggestionsForMasterAgent($request, true)) + sizeof($this->agentManager->getDowngradeSuggestionsForActiveAgent($request, true)));
            $firstDowngrades = $this->agentManager->getDowngradeSuggestionsForMasterAgent($request);

            if (($size = sizeof($firstDowngrades)) < $offset) {
                if($size != 0){
                    $data['downgrades']['data'] = array_merge($firstDowngrades, $this->agentManager->getDowngradeSuggestionsForActiveAgent($request, false, 0, $offset - $size));
                } else {
                    $totalOfMADowngrades = intval(sizeof($this->agentManager->getDowngradeSuggestionsForMasterAgent($request, true)));
                    $pagesOfMA = ceil($totalOfMADowngrades/$offset);
                    $firstResForAA = ($page - $pagesOfMA - 1) * $offset + ($totalOfMADowngrades % $offset);

                    $data['downgrades']['data'] = array_merge($firstDowngrades,$this->agentManager->getDowngradeSuggestionsForActiveAgent($request, false, $firstResForAA, $offset));
                }

            } else {
                $data['downgrades']['data'] = array_merge($firstDowngrades);
            }

            $data['downgrades']['meta'] = array_merge(array('page'=>$page, 'pages' => ceil($downgradeTotalItems/$offset), 'totalItems' => $downgradeTotalItems));
        }

        $data['role_codes'] = array(
            'role_active_agent' => RoleHelper::ACTIVE,
            'role_master_agent' => RoleHelper::MASTER,
            'role_referee'      => RoleHelper::REFEREE
        );

        return $data;
    }

    /**
     * @param $agentId
     * @param $superiorId
     * @return mixed
     */
    public function promoteAgent($agentId, $superiorId)
    {
        /**
         * @var $agent Agent
         */
        $agent = $this->agentManager->findAgentById($agentId);
        $agent->setPaymentsNumb(0);
        if(is_null($superiorId)){
            $group = $this->groupManager->findGroupByName(RoleHelper::MASTER);
            $agent->setGroup($group);
        } else {
            $group = $this->groupManager->findGroupByName(RoleHelper::ACTIVE);
            $agent->setGroup($group);
            $superior = $this->agentManager->getReference($superiorId);
            $agent->setSuperior($superior);
        }

        return $this->agentManager->updateResource($agent, true);
    }

    /**
     * @param $agentId
     * @param $newSuperiorId
     * @return mixed
     */
    public function demoteAgent($agentId, $newSuperiorId)
    {
        /**
         * @var $agent Agent
         */
        $agent = $this->agentManager->findAgentById($agentId);
        $agent->setPaymentsNumb(0);
        if(is_null($newSuperiorId)){
            $group = $this->groupManager->findGroupByName(RoleHelper::ACTIVE);
            $agent->setGroup($group);
        } else {
            $group = $this->groupManager->findGroupByName(RoleHelper::REFEREE);
            $agent->setGroup($group);
            $agent->setNewSuperiorId($newSuperiorId);
            $superior = $this->agentManager->findAgentByRole(RoleManager::ROLE_SUPER_ADMIN);
            $agent->setSuperior($superior);
        }

        return $this->agentManager->updateResource($agent, true);

    }
}