<?php

namespace ConversationBundle\Business\Manager\Ticket;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class JsonApiGetTicketManagerTrait
 * @package ConversationBundle\Business\Manager\Ticket
 */
trait JsonApiGetTicketManagerTrait
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