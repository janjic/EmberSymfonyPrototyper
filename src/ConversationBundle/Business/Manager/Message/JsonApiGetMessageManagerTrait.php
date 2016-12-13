<?php

namespace ConversationBundle\Business\Manager\Message;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class JsonApiGetMessageManagerTrait
 * @package ConversationBundle\Business\Manager\Message
 */
trait JsonApiGetMessageManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function getResource($id = null)
    {
//        return $this->createJsonApiGetResponse($this->repository->findAgentById($id));

    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonApiGetResponse($data)
    {
//        if (!is_null($data))  {
//            return new ArrayCollection($this->serializeAgent($data)->toArray());
//        }
//
//        return new ArrayCollection(AgentApiResponse::AGENT_NOT_FOUND_RESPONSE);
    }


}