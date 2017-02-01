<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\Agent;

/**
 * Class JsonApiGetAgentManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiGetAgentManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function getResource($id = null)
    {
        $agent = $this->repository->findAgentById($id);

        /** @var Agent $currentUser */
        $currentUser = $this->tokenStorage->getToken()->getUser();
        if (!$currentUser || !($currentUser->getLft() <= $agent->getLft() && $currentUser->getRgt() >= $agent->getRgt())) {
            return new ArrayCollection(AgentApiResponse::AGENT_ACCESS_DENIED);
        }

        return $this->createJsonApiGetResponse($agent);

    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonApiGetResponse($data)
    {
        if (!is_null($data))  {
            return new ArrayCollection($this->serializeAgent($data)->toArray());
        }

        return new ArrayCollection(AgentApiResponse::AGENT_NOT_FOUND_RESPONSE);
    }


}