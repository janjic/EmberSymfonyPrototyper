<?php

namespace ConversationBundle\Business\Manager\Message;

use ConversationBundle\Entity\Message;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\MessageBuilder\NewThreadMessageBuilder;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiSaveMessageManagerTrait
 * @package ConversationBundle\Business\Manager\Message
 */
trait JsonApiSaveMessageManagerTrait
{

    protected $saveEventResult;

    /**
     * {@inheritdoc}
     */
    public function saveResource($data)
    {
        /** @var Message $message */
        $message = $this->deserializeMessage($data);

        /** @var NewThreadMessageBuilder $thread */
        $thread = $this->messageComposer->newThread();
        $thread->setSubject($message->getMessageSubject());
        $thread->setBody($message->getBody());
        $thread->addRecipient($this->repository->getReferenceForClass($message->getParticipants()[0]->getId(), Agent::class));
        $thread->setSender($this->repository->getReferenceForClass($message->getSender()->getId(), Agent::class));

        $newMessage = $thread->getMessage();

        try {
            $this->eventDispatcher->addListener(FOSMessageEvents::POST_SEND, function($e) {
                $this->saveEventResult = $e->getMessage();
            });

            $this->messageSender->send($newMessage);

            return $this->serializeMessage($this->saveEventResult);

        } catch (Exception $e) {
            return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($e));
        }

    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
//        switch (get_class($data)) {
//            case UniqueConstraintViolationException::class:
//                return new ArrayCollection(AgentApiResponse::AGENT_ALREADY_EXIST);
//            case Exception::class:
//                return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
//            case (Agent::class && ($id= $data->getId())):
//                return new ArrayCollection(AgentApiResponse::AGENT_SAVED_SUCCESSFULLY($id));
//            case (Agent::class && !($id= $data->getId()) && $data->getImage()):
//                return new ArrayCollection(AgentApiResponse::AGENT_SAVED_FILE_FAILED_RESPONSE);
//            default:
//                return false;
//        }
    }


}