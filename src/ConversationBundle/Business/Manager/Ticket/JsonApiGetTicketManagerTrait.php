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
        $ticket = $this->repository->findTicketById($id);

        return $this->createJsonApiGetResponse($ticket);

    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonApiGetResponse($data)
    {
        if (!is_null($data))  {
            return new ArrayCollection($this->serializeTicket($data)->toArray());
        }

        return new ArrayCollection(AgentApiResponse::AGENT_NOT_FOUND_RESPONSE);
    }

}