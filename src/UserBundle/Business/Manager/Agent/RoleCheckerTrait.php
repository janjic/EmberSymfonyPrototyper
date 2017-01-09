<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Business\Manager\RoleManager;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class RoleCheckerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait RoleCheckerTrait
{
    /**
     * @param Agent $agent
     * @return bool
     */
    public function isReferee($agent)
    {
        return $this->isAgentOfType($agent, RoleManager::ROLE_REFEREE);
    }

    /**
     * @param Agent $agent
     * @return bool
     */
    public function isActiveAgent($agent)
    {
        return $this->isAgentOfType($agent, RoleManager::ROLE_ACTIVE_AGENT);
    }

    /**
     * @param Agent $agent
     * @return bool
     */
    public function isMasterAgent($agent)
    {
        return $this->isAgentOfType($agent, RoleManager::ROLE_MASTER_AGENT);
    }

    /**
     * @param Agent $agent
     * @return bool
     */
    public function isAmbassador($agent)
    {
        return $this->isAgentOfType($agent, RoleManager::ROLE_AMBASSADOR);
    }

    /**
     * @param Agent $agent
     * @return bool
     */
    public function isHQ($agent)
    {
        return $this->isAgentOfType($agent, RoleManager::ROLE_SUPER_ADMIN);
    }

    /**
     * @param Agent  $agent
     * @param string $type
     * @return bool
     */
    public function isAgentOfType($agent, $type)
    {
        return (is_array($agent->getRoles()) && $agent->getRoles()[0] == $type);
    }

    /**
     * @param Agent $mainAgent
     * @param Agent $agent
     * @return bool
     */
    public function hasHigherOrSameRole($mainAgent, $agent) {
        if ($mainAgent->getRoles()[0] === $agent->getRoles()[0]) {
            return true;
        }

        foreach ($mainAgent->getRoles() as $role) {
            if (!in_array($role, $agent->getRoles())) {
                return true;
            }
        }

        return false;
    }
}