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
use UserBundle\Business\Manager\AgentManager;
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
        $d = json_decode($data, true);
        if (array_key_exists('thread', $d['data']['relationships']) && $d['data']['relationships']['thread']['data']) {
            /** @var Message $message */
            $message = $this->deserializeMessage($data);
        } else {
            /** @var Message $message */
            $message = $this->deserializeMessageWithoutThread($data);
        }

        if ($message->isIsDraft()) {
            return $this->saveDraft($message);
        }

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

            // SENDING NOTIFICATION IF MESSAGE IS NOT DRAFT
            if( !$messageFronted->isIsDraft() && (!$messageFronted->getThread() ||
                    !$this->repository->getReferenceForClass($messageFronted->getThread()->getId(), Thread::class)->isisTicketThread()) ) {
                /** @var Agent $user */
//                $user = $this->getCurrentUser();
//                $userRecipient =  $newMessage->getParticipantsFromMeta()[0]->getId() == $user->getId() ? $newMessage->getParticipantsFromMeta()[1] : $newMessage->getParticipantsFromMeta()[0];
//                if( in_array('optionMessage', $userRecipient->getNotifications()) ) {
                    $notification = NotificationManager::createNewMessageNotification($newMessage);
                    $event = new NotificationEvent();
                    $event->setMessage($newMessage);
                    $event->addNotification($notification);

                    $this->eventDispatcher->dispatch(NotificationEvents::ON_NOTIFICATION_ACTION, $event);
//                }
            }

            return $this->serializeMessage($this->saveEventResult);

        } catch (Exception $e) {
            /** @var File $file */
            if ($file = $messageFronted->getFile()) {
                $file->deleteFile();
            }

            return array(AgentApiResponse::ERROR_RESPONSE($e));
        }
    }

    /**
     * @param Message $message
     * @return array
     */
    public function saveDraft($message)
    {
        /** @var File $file */
        if (($file = $message->getFile()) && $file->getBase64Content() && !$this->saveMedia($message)) {
            return array(AgentApiResponse::MESSAGES_UNSUPPORTED_FORMAT);
        }

        /** @var NewThreadMessageBuilder $thread */
        $thread = $this->messageComposer->newThread();
        if ($message->getMessageSubject()) {
            $thread->setSubject($message->getMessageSubject());
        }

        if ($message->getBody()) {
            $thread->setBody($message->getBody());
        }

        if ($message->getParticipants()[0]) {
            $thread->addRecipient($this->repository->getReferenceForClass($message->getParticipants()[0]->getId(), Agent::class));
        }

        $thread->setSender($this->repository->getReferenceForClass($message->getSender()->getId(), Agent::class));
        $thread->getMessage()->getThread()->setIsDraft(true);

        return $this->processSave($thread->getMessage(), $message);
    }

}