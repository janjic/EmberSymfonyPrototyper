<?php

namespace MailCampaignBundle\Business\Manager\MailList;

use ConversationBundle\Entity\Ticket;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\Agent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class JsonApiGetMailListManagerTrait
 * @package MailCampaignBundle\Business\Manager\MailList
 */
trait JsonApiGetMailListManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function getResource($id = null)
    {
//        /**
//         * @var Ticket $ticket
//         */
//        $ticket = $this->repository->findTicketById($id);
//        /**
//         * @var  Agent $currentUser
//         */
//        $currentUser = $this->getCurrentUser();
//
//        if(!is_null($ticket->getThread())){
//            /**
//             * @var ArrayCollection $participants
//             */
//            $participants = new ArrayCollection($ticket->getThread()->getParticipants());
//            /**
//             * Check if current user is participant
//             */
//            $canViewThread = $participants->exists(function ($key, $element) use ($currentUser){
//                return $element->getId() == $currentUser->getId();
//            });
//
//            if(!$canViewThread && !$currentUser->hasRole('SUPER_ADMIN')){
//                $ticket = new AccessDeniedException();
//            }
//        }
//
//        return $this->createJsonApiGetResponse($ticket);

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