<?php

namespace UserBundle\Business\Manager\AgentHistory;

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
     * @param bool  $changedToSuspended
     */
    public function saveChangeHistory(Agent $agent, Group $oldGroup = null, $changedToSuspended = null)
    {
        $agentHistory = new AgentHistory();
        $agentHistory->setAgent($agent);
        $agentHistory->setChangedByAgent($this->getCurrentUser());

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

            $agentHistory->setChangedType( $hasAllRoles ? 'DOWNGRADE' : 'UPGRADE');
        }

        if ($changedToSuspended !== null) {
            $agentHistory->setChangedToSuspended(!$changedToSuspended);
            $agentHistory->setChangedType(($ct = $agentHistory->getChangedType()) ? $ct.', SUSPENSION' : 'SUSPENSION');
        }

        $this->repository->saveHistory($agentHistory);
    }
}