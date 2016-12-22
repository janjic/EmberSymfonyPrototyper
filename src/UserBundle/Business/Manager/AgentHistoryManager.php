<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\AgentHistory\JsonApiJQGridAgentHistoryManagerTrait;
use UserBundle\Business\Manager\AgentHistory\JsonApiSaveAgentHistoryManagerTrait;
use UserBundle\Business\Repository\AgentHistoryRepository;
use UserBundle\Entity\Agent;
use UserBundle\Entity\AgentHistory;
use UserBundle\Entity\Group;

/**
 * Class AgentHistoryManager
 * @package UserBundle\Business\Manager
 */
class AgentHistoryManager implements JSONAPIEntityManagerInterface
{

    use JsonApiJQGridAgentHistoryManagerTrait;
    use JsonApiSaveAgentHistoryManagerTrait;

    /**
     * @var AgentHistoryRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @var TokenStorageInterface $tokenStorage
     */
    protected $tokenStorage;

    /**
     * @param AgentHistoryRepository $repository
     * @param FJsonApiSerializer     $fSerializer
     * @param TokenStorageInterface  $tokenStorage
     */
    public function __construct(AgentHistoryRepository $repository, FJsonApiSerializer $fSerializer, TokenStorageInterface $tokenStorage)
    {
        $this->repository   = $repository;
        $this->fSerializer  = $fSerializer;
        $this->tokenStorage = $tokenStorage;
    }

    public function serializeAgentHistory($content, $metaTags, $mappings = null)
    {
        $relations = array('agent', 'changedByAgent', 'changedFrom', 'changedTo');
        if (!$mappings) {
            $mappings = array(
                'agentHistory'   => array('class' => AgentHistory::class, 'type'=>'agent-histories'),
                'agent'          => array('class' => Agent::class, 'type'=>'agents'),
                'changedByAgent' => array('class' => Agent::class, 'type'=>'agents'),
                'changedFrom'    => array('class' => Group::class, 'type'=>'groups'),
                'changedTo'      => array('class' => Group::class, 'type'=>'groups')
            );
        }

        $serialize = $this->fSerializer->serialize($content, $mappings, $relations);

        foreach ($metaTags as $key=>$meta) {
            $serialize->addMeta($key, $meta);
        }

        return $serialize->toArray();
    }

    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    public function getResource($id = null)
    {
        // TODO: Implement getResource() method.
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