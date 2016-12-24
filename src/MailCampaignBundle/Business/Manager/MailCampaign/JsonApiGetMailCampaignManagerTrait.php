<?php

namespace MailCampaignBundle\Business\Manager\MailCampaign;

use ConversationBundle\Entity\Ticket;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\Agent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class JsonApiGetMailCampaignManagerTrait
 * @package MailCampaignBundle\Business\Manager\Ticket
 */
trait JsonApiGetMailCampaignManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function getResource($id = null)
    {


    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonApiGetResponse($data)
    {
//        if (!is_null($data) && get_class($data) == Ticket::class)  {
//            return new ArrayCollection($this->serializeTicket($data)->toArray());
//        } else if(!is_null($data) && get_class($data) == AccessDeniedException::class) {
//            return new ArrayCollection(AgentApiResponse::ACCESS_TO_TICKET_DENIED);
//        }
//
//        return new ArrayCollection(AgentApiResponse::AGENT_NOT_FOUND_RESPONSE);
    }

}