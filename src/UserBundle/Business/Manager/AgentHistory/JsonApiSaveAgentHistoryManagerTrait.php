<?php

namespace UserBundle\Business\Manager\AgentHistory;

use UserBundle\Business\Manager\AgentHistoryManager;
use UserBundle\Entity\Agent;
use UserBundle\Entity\AgentHistory;
use UserBundle\Entity\Group;

/**
 * Class JsonApiSaveAgentHistoryManagerTrait
 * @package UserBundle\Business\Manager\AgentHistory
 */
trait JsonApiSaveAgentHistoryManagerTrait
{
    /**
     * @param Agent $agent
     * @param Group $oldGroup
     * @param bool $changedToSuspended
     * @param int $activeAgentsNumb
     * @param int $numbOfSales
     */
    public function saveChangeHistory(Agent $agent, Group $oldGroup = null, $changedToSuspended = null, $activeAgentsNumb = 0, $numbOfSales = 0)
    {
        $agentHistory = new AgentHistory();
        $agentHistory->setAgent($agent);
        $agentHistory->setChangedByAgent($this->getCurrentUser());
        $agentHistory->setActiveAgentsNumb($activeAgentsNumb);
        $agentHistory->setNumbOfSales($numbOfSales);
        if ($oldGroup !== null) {
            $agentHistory->setChangedFrom($oldGroup);
            $agentHistory->setChangedTo($agent->getGroup());

            $hasAllRoles = true;
            foreach ($oldGroup->getRoles() as $role) {
                $hasThisRole = true;
                foreach ($agent->getRoles() as $agentRole) {
                    if ($role->getRole() == $agentRole) {
                        $hasThisRole = false;
                        break;
                    };
                }
                if (!$hasThisRole) {
                    $hasAllRoles = false;
                    break;
                }
            }

            $agentHistory->setChangedType( $hasAllRoles ? AgentHistoryManager::DOWNGRADE_STATUS : AgentHistoryManager::UPGRADE_STATUS);
        }

        if($agentHistory->getChangedType()){
            /**
             * Save record if role changed
             */
            $this->repository->saveHistory($agentHistory);
        }

        if ($changedToSuspended !== null) {
            /**
             * Save another record if status changed
             */
            $agentHistorySuspension = new AgentHistory();
            $agentHistorySuspension->setAgent($agent);
            $agentHistorySuspension->setChangedByAgent($this->getCurrentUser());
            $agentHistorySuspension->setActiveAgentsNumb($activeAgentsNumb);
            $agentHistorySuspension->setNumbOfSales($numbOfSales);
            $agentHistorySuspension->setChangedToSuspended(!$changedToSuspended);
            $agentHistorySuspension->setChangedType($changedToSuspended ? AgentHistoryManager::ENABLED_STATUS : AgentHistoryManager::SUSPENDED_STATUS);
            $this->repository->saveHistory($agentHistorySuspension);
        }
    }
}