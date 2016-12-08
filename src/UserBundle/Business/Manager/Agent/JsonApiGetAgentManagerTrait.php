<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;

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
        return $this->createJsonApiGetResponse($this->repository->findAgentById($id));

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