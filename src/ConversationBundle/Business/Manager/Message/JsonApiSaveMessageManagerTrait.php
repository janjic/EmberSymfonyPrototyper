<?php

namespace ConversationBundle\Business\Manager\Message;

use ConversationBundle\Business\Event\Thread\ThreadEvents;
use ConversationBundle\Business\Event\Thread\ThreadReadEvent;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Adapter\AgentApiResponse;
use Exception;
use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\MessageBuilder\NewThreadMessageBuilder;
use FOS\MessageBundle\MessageBuilder\ReplyMessageBuilder;
use FOS\MessageBundle\Model\MessageInterface;
use UserBundle\Business\Event\Notification\NotificationEvent;
use UserBundle\Business\Event\Notification\NotificationEvents;
use UserBundle\Business\Manager\NotificationManager;
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
        if ($message->getThread() && $message->getThread()->getId()) {
            return $this->replyToMessage($message);
        } else {
            return $this->createThread($message);
        }
    }

    /**
     * Create new thread
     * @param $message
     * @return array
     */
    public function createThread($message)
    {
        /** @var NewThreadMessageBuilder $thread */
        $thread = $this->messageComposer->newThread();
        $thread->setSubject($message->getMessageSubject());
        $thread->setBody($message->getBody());
        $thread->addRecipient($this->repository->getReferenceForClass($message->getParticipants()[0]->getId(), Agent::class));
        $thread->setSender($this->repository->getReferenceForClass($message->getSender()->getId(), Agent::class));

        $thread->getMessage()->getThread()->setIsRead(true);
        $event = new ThreadReadEvent($thread->getMessage()->getThread());
        $this->eventDispatcher->dispatch(ThreadEvents::ON_THREAD_READ, $event);

        return $this->processSave($thread->getMessage(), $message);
    }

    /**
     * Replay to message in thread
     * @param Message $msg
     * @return array
     */
    public function replyToMessage(Message $msg) {
        $thread = $this->repository->getReferenceForClass($msg->getThread()->getId(), Thread::class);
        /** @var ReplyMessageBuilder $messageBuilder */
        $messageBuilder = $this->messageComposer->reply($thread);
        $messageBuilder->setBody($msg->getBody());
        $messageBuilder->setSender($this->repository->getReferenceForClass($msg->getSender()->getId(), Agent::class));

        $messageBuilder->getMessage()->getThread()->setAsUnreadForOtherParticipants($msg->getSender());

        return $this->processSave($messageBuilder->getMessage(), $msg);
    }

    /**
     * @param MessageInterface $newMessage
     * @param Message $messageFronted
     * @return array
     */
    public function processSave($newMessage, $messageFronted)
    {
        try {
            $this->eventDispatcher->addListener(FOSMessageEvents::POST_SEND, function($e) {
                $this->saveEventResult = $e->getMessage();
            });

            if ($messageFronted->getFile() && !$this->saveMedia($messageFronted)) {
                return array(AgentApiResponse::MESSAGES_UNSUPPORTED_FORMAT);
            }
            $newMessage->setFile($messageFronted->getFile());
            $this->messageSender->send($newMessage);

            $this->saveEventResult->getThread()->setIsRead(true);

            // SENDING NOTIFICATION
            $user = $newMessage->getSender();
//            $user = $messageFronted->getParticipantsFromMeta();
            $notification = NotificationManager::createNewMessageNotification($user, 'You got new message!');
            $event = new NotificationEvent();
            $event->addNotification($notification);

            $this->eventDispatcher->dispatch(NotificationEvents::ON_NOTIFICATION_ACTION, $event);
            $this->eventDispatcher->dispatch("uradi.odma");

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