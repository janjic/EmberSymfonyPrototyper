<?php

namespace ConversationBundle\Business\Manager\Ticket;
use ConversationBundle\Entity\Ticket;
use ConversationBundle\Entity\TicketStatuses;
use ConversationBundle\Entity\TicketTypes;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\MessageBuilder\NewThreadMessageBuilder;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiSaveTicketManagerTrait
 * @package ConversationBundle\Business\Manager\Ticket
 */
trait JsonApiSaveTicketManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function saveResource($data)
    {
        /**
         * Deserialize ticket
         */
        $ticket = $this->deserializeTicket($data);

        /**
         * Prepare ticket object for saving
         */
        $ticket = $this->prepareSave($ticket);
        if ($ticket === AgentApiResponse::TICKET_THREAD_NOT_SAVED) {
            return new ArrayCollection($ticket);
        }

        /** @var Agent|Exception $agent */
        $data = $this->save($ticket);

        /** @var Image|null $image */;
        if ($data instanceof Exception) {
            !is_null($file = $ticket->getFile()) ? $file->deleteFile() : false;
            return $this->createJsonAPiSaveResponse($data);
        }


        return $this->createJsonAPiSaveResponse($data);
    }

    /**
     * @param Ticket $ticket
     * @return bool|Ticket|array
     * @throws Exception
     */
    private function prepareSave(Ticket $ticket)
    {
        /**
         * Check if ticket type is valid
         */
        if(!in_array($ticket->getType(), TicketTypes::getPossibleValues())) {
            throw new Exception('Ticket type not supported');
        }

        /**
         * Set createdAt date
         */
        $ticket->setCreatedAt(new DateTime());

        /**
         * Set ticket status to new on creation
         */
        $ticket->setStatus(TicketStatuses::STATUS_NEW);

        /**
         * Save ticket file if exists
         */
        if ($ticket->getFile() && $ticket->getFile()->getBase64Content()) {
            $this->saveMedia($ticket);
        } else {
            $ticket->setFile(null);
        }

        /** @var NewThreadMessageBuilder $thread */
        $thread = $this->messageComposer->newThread();
        $thread->setSubject($ticket->getTitle());
        $thread->setBody($ticket->getText());
        $creator = $this->repository->getReferenceForClass($ticket->getCreatedBy()->getId(), Agent::class);
        $thread->setSender($creator);
        $thread->getMessage()->getThread()->setIsTicketThread(true);

        $this->eventDispatcher->addListener(FOSMessageEvents::POST_SEND, function($e) {
            $this->saveEventResult = $e->getMessage();
        });

        $this->messageSender->send($thread->getMessage());

        if (!$this->saveEventResult) {
            return AgentApiResponse::TICKET_THREAD_NOT_SAVED;
        }

        $ticket->setThread($thread->getMessage()->getThread());
        $ticket->getThread()->setCreatedBy($creator);
        /**
         * Set agent to createdBy
         */
        $ticket->setCreatedBy($creator);

        return $ticket;
    }

    /**
     * @param Ticket $ticket
     * @return bool
     */
    private function saveMedia($ticket)
    {
        /** @var File $file */
        $file = $ticket->getFile();
        if ($file->saveToFile($file->getBase64Content())) {
            return true;
        }

        return false;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        switch (get_class($data)) {
            case Exception::class:
                return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
            case (Ticket::class && ($id = $data->getId())):
                return new ArrayCollection(AgentApiResponse::TICKET_SAVED_SUCCESSFULLY($id));
            case (Ticket::class && !($id = $data->getId()) && $data->getFile()):
                return new ArrayCollection(AgentApiResponse::AGENT_SAVED_FILE_FAILED_RESPONSE);
            default:
                return false;
        }
    }

}