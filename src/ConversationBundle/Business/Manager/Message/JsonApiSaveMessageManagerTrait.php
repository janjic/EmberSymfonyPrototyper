<?php

namespace ConversationBundle\Business\Manager\Message;

use ConversationBundle\Entity\Message;
use CoreBundle\Adapter\AgentApiResponse;
use Exception;
use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\MessageBuilder\NewThreadMessageBuilder;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;

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

        /** @var Message $message */
        $newMessage = $thread->getMessage();

        try {
            $this->eventDispatcher->addListener(FOSMessageEvents::POST_SEND, function($e) {
                $this->saveEventResult = $e->getMessage();
            });

            if ($message->getFile() && !$this->saveMedia($message)) {
                return array(AgentApiResponse::MESSAGES_UNSUPPORTED_FORMAT);
            }
            $newMessage->setFile($message->getFile());
            $this->messageSender->send($newMessage);

            return $this->serializeMessage($this->saveEventResult);

        } catch (Exception $e) {
            return array(AgentApiResponse::ERROR_RESPONSE($e));
        }

    }

    /**
     * @param Message $message
     * @return bool
     */
    private function saveMedia($message)
    {
        /** @var File|null $image */
        $file = $message->getFile();
        if(!is_null($file)){
            if ($file->saveToFile($file->getBase64Content())) {
                return true;
            }
            return false;
        }

        return true;
    }

}