<?php

namespace MailCampaignBundle\Business\Manager\MailCampaign;
use ConversationBundle\Entity\Ticket;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiUpdateTicketManagerTrait
 * @package MailCampaignBundle\Business\Manager\Ticket
 */
trait JsonApiUpdateMailCampaignManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function updateResource($data)
    {
//        $ticket = $this->deserializeTicket($data);
//        $ticket = $this->prepareUpdate($ticket);
//        if(get_class($ticket) == Ticket::class){
//            $ticket = $this->repository->editTicket($ticket);
//        }
//
//        return $this->createResponse($ticket);
    }

    /**
     * @param Ticket $ticket
     * @return Ticket|Exception
     */
    private function prepareUpdate(Ticket $ticket)
    {
//        /**
//         * Check if author and recipient are the same
//         */
//        if(!is_null($ticket->getForwardedTo())){
//            if($ticket->getForwardedTo()->getId() == $ticket->getCreatedBy()->getId()){
//                $ticket = new Exception('Author and recipient can not be the same');
//            } else if($ticket->getForwardedTo()->getId() == $this->getCurrentUser()->getId()){
//                $ticket = new Exception('Can not set self as recipient');
//            }
//            return $ticket;
//        }
//
//        /**
//         * If forwarded to exists get its reference
//         */
//        if(!is_null($ticket->getForwardedTo())){
//            $agent = $this->getAgentById($ticket->getForwardedTo()->getId());
//            $ticket->setForwardedTo($agent);
//        }
//        /**
//         * Get reference to author
//         */
//        $ticket->setCreatedBy($this->repository->getReferenceForClass($ticket->getCreatedBy()->getId(), Agent::class));
//
//        /**
//         * Convert string to date format
//         */
//        //$ticket->setCreatedAt(new DateTime($ticket->getCreatedAt()));
//
//
//        return $ticket;

    }

    private function saveToFile($agent)
    {
//        /**  */
//        if(!is_null($image = $agent->getImage())){
//            if ($image->saveToFile($image->getBase64Content())) {
//                $agent->setBaseImageUrl($image->getWebPath());
//                return true;
//            }
//            return false;
//        }
//
//        return true;

    }

    /**
     * @param $data
     * @return mixed
     */
    private function createResponse($data)
    {
//        switch (get_class($data)) {
//            case Ticket::class:
//                if($id= $data->getId()){
//                    return new ArrayCollection(AgentApiResponse::TICKET_SAVED_SUCCESSFULLY($id));
//                } else {
//                    return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
//                }
//            case Exception::class:
//                return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
//            default:
//                return false;
//        }
    }



}