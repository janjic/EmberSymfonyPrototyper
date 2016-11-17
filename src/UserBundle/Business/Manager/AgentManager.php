<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use UserBundle\Business\Repository\AgentRepository;
use UserBundle\Business\Repository\GroupRepository;
use UserBundle\Entity\Agent;

/**
 * Class AgentManager
 * @package UserBundle\Business\Manager
 */
class AgentManager implements BasicEntityManagerInterface
{
    /**
     * @var GroupRepository
     */
    protected $repository;

    protected $groupManager;

    /**
     * @param AgentRepository $repository
     * @param GroupManager    $groupManager
     */
    public function __construct(AgentRepository $repository, GroupManager $groupManager)
    {
        $this->repository = $repository;
        $this->groupManager = $groupManager;
    }

    public function getGroupById($id)
    {
        return $this->groupManager->getGroupById($id);
    }

    /**
     * @param Agent $agent
     * @return Agent
     */
    public function save(Agent $agent)
    {
        return $this->repository->saveAgent($agent);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findAgentById($id)
    {
        return $this->repository->findAgentById($id);
    }

}