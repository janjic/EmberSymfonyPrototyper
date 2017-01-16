<?php

namespace PaymentBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FSerializerBundle\services\FJsonApiSerializer;
use PaymentBundle\Business\Manager\Payment\PaymentInfoCreationTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoGetTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoJQGridTrait;
use PaymentBundle\Business\Manager\Payment\PaymentInfoSerializationTrait;
use PaymentBundle\Business\Repository\PaymentInfoRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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

    /**
     * @var TokenStorageInterface $tokenStorage
     */
    protected $tokenStorage;

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
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(PaymentInfoRepository $repository, AgentManager $agentManager, FJsonApiSerializer $fSerializer, CommissionManager $commissionManager, TokenStorageInterface $tokenStorage)
    {
        $this->repository        = $repository;
        $this->agentManager      = $agentManager;
        $this->fSerializer       = $fSerializer;
        $this->commissionManager = $commissionManager;
        $this->tokenStorage     = $tokenStorage;
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

}