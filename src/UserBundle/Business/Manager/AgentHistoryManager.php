<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\AgentHistory\JsonApiJQGridAgentHistoryManagerTrait;
use UserBundle\Business\Manager\AgentHistory\JsonApiSaveAgentHistoryManagerTrait;
use UserBundle\Business\Repository\AgentHistoryRepository;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Agent;
use UserBundle\Entity\AgentHistory;
use UserBundle\Entity\Group;

/**
 * Class AgentHistoryManager
 * @package UserBundle\Business\Manager
 */
class AgentHistoryManager implements JSONAPIEntityManagerInterface
{

    const DOWNGRADE_STATUS = 'DOWNGRADE';
    const UPGRADE_STATUS   = 'UPGRADE';
    const SUSPENDED_STATUS = 'SUSPENSION';
    const ENABLED_STATUS   = 'RESUMPTION';

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
     * @var RequestStack $request
     */
    protected $request;

    /**
     * @param AgentHistoryRepository $repository
     * @param FJsonApiSerializer $fSerializer
     * @param TokenStorageInterface $tokenStorage
     * @param Request $request
     */
    public function __construct(AgentHistoryRepository $repository, FJsonApiSerializer $fSerializer, TokenStorageInterface $tokenStorage, RequestStack $request)
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

        $serialize = $this->fSerializer->serialize($content, $mappings, $relations, array(), AgentSerializerInfo::$basicFields);

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

    /**
     * @param null $id
     * @return array
     */
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

    /**
     * @param Request $request
     * @return array
     */
    public function getQueryResult(Request $request)
    {
        if($agentId = $request->get('agentId')){
            $data = $this->repository->getAgentHistory($agentId);
            $serializedData = $this->serializeAgentHistory($data, []);

            return new ArrayCollection($serializedData);
        }
    }



}