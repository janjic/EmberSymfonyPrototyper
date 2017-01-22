<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Event\Thread\ThreadEvents;
use ConversationBundle\Business\Event\Thread\ThreadReadEvent;
use ConversationBundle\Business\Manager\Message\JsonApiSaveMessageManagerTrait;
use ConversationBundle\Business\Repository\MessageRepository;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\MessageMetadata;
use ConversationBundle\Entity\Thread;
use ConversationBundle\Entity\ThreadMetadata;
use CoreBundle\Adapter\AgentApiResponse;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\Serializer\JsonApiMany;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Business\Event\Notification\NotificationEvent;
use UserBundle\Business\Event\Notification\NotificationEvents;
use UserBundle\Business\Manager\NotificationManager;
use UserBundle\Entity\Agent;
use FOS\MessageBundle\Composer\Composer as MessageComposer;
use FOS\MessageBundle\Sender\Sender as MessageSender;
use UserBundle\Entity\Document\File;

/**
 * Class MessageManager
 * @package ConversationBundle\Business\Manager
 */
class MessageManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiSaveMessageManagerTrait;

    /**
     * @var MessageRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @var MessageComposer $messageComposer
     */
    protected $messageComposer;

    /**
     * @var MessageSender $messageSender
     */
    protected $messageSender;

    /**
     * @var EventDispatcherInterface $eventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var TokenStorageInterface $tokenStorage
     */
    protected $tokenStorage;

    /**
     * @param MessageRepository        $repository
     * @param FJsonApiSerializer       $fSerializer
     * @param MessageComposer          $messageComposer
     * @param MessageSender            $messageSender
     * @param EventDispatcherInterface $eventDispatcher
     * @param TokenStorageInterface    $tokenStorage
     */
    public function __construct(MessageRepository $repository, FJsonApiSerializer $fSerializer, MessageComposer $messageComposer,
                                MessageSender $messageSender, EventDispatcherInterface $eventDispatcher, TokenStorageInterface $tokenStorage)
    {
        $this->repository       = $repository;
        $this->fSerializer      = $fSerializer;
        $this->messageComposer  = $messageComposer;
        $this->messageSender    = $messageSender;
        $this->eventDispatcher  = $eventDispatcher;
        $this->tokenStorage     = $tokenStorage;

    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeMessage($content, $mappings = null)
    {
        $relations = array('sender', 'thread', 'participants', 'file');
        if (!$mappings) {
            $mappings = array(
                'message'      => array('class' => Message::class, 'type'=>'messages'),
                'sender'       => array('class' => Agent::class, 'type'=>'agents'),
                'participants' => array('class' => Agent::class, 'type'=>'agents', 'jsonApiType'=>JsonApiMany::class),
                'file'         => array('class' => File::class, 'type'=>'files'),
                'thread'       => array('class' => Thread::class, 'type'=>'threads'),
            );
        }

        return $this->fSerializer->setDeserializationClass(Message::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeMessageWithoutThread($content, $mappings = null)
    {
        $relations = array('sender', 'participants', 'file');
        if (!$mappings) {
            $mappings = array(
                'message'      => array('class' => Message::class, 'type'=>'messages'),
                'sender'       => array('class' => Agent::class, 'type'=>'agents'),
                'participants' => array('class' => Agent::class, 'type'=>'agents', 'jsonApiType'=>JsonApiMany::class),
                'file'         => array('class' => File::class, 'type'=>'files'),
            );
        }

        return $this->fSerializer->setDeserializationClass(Message::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param array $metaTags
     * @param null $mappings
     * @return mixed
     */
    public function serializeMessage($content ,$metaTags = [], $mappings = null)
    {
        $relations = array('sender', 'thread', 'file');
        if (!$mappings) {
            $mappings = array(
                'message' => array('class' => Message::class, 'type'=>'messages'),
                'sender'  => array('class' => Agent::class, 'type'=>'agents'),
                'thread'  => array('class' => Thread::class, 'type'=>'threads'),
                'file'    => array('class' => File::class, 'type'=>'files'),
            );
        }

        $serialize = $this->fSerializer->serialize($content, $mappings, $relations);

        foreach ($metaTags as $key=>$meta) {
            $serialize->addMeta($key, $meta);
        }

        return $serialize->toArray();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getQueryResult($request)
    {
        $perPage    = $request->query->get('per_page');
        $threadId   = $request->query->get('thread');
        $minId      = $request->query->get('min_id');
        $maxId      = $request->query->get('max_id');
        $page       = ($p = $request->query->get('page')) ? $p : 1;

        $messages   = $this->repository->getMessagesForThread($threadId, $page,
            $perPage, $minId, $maxId);

        $totalItems = $this->repository->getMessagesForThread($threadId, null, null, null, null, true)[0][1];

        if (array_key_exists(0, $messages)) {
            $messages[0]->getThread()->setIsRead(true);
            $event = new ThreadReadEvent($messages[0]->getThread());
            $this->eventDispatcher->dispatch(ThreadEvents::ON_THREAD_READ, $event);
        }

        return $this->serializeMessage($messages, ['total_pages'=>ceil($totalItems / $perPage)]);
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getResource($id = null)
    {
        // TODO: Implement getResource() method.
    }

    /**
     * Message update means draft is being sent
     * @param $data
     * @return mixed
     */
    public function updateResource($data)
    {
        /** @var Message $message */
        $message   = $this->deserializeMessage($data);

        /** @var Message $messageDB */
        $messageDB = $this->repository->findOneById($message->getId());
        $messageDB->getThread()->setIsDraft($message->isIsDraft());

        $messageDB->setBody($message->getBody());
        $messageDB->getThread()->setSubject($message->getMessageSubject());

        /** @var MessageMetadata $meta */
        foreach ($messageDB->getAllMetadata() as $meta) {
            if ($meta->getParticipant()->getId() != $this->getCurrentUser()->getId() &&
                $meta->getParticipant()->getId() != ($newId = $message->getParticipants()[0]->getId())
            ) {
                $meta->setParticipant($this->repository->getReferenceForClass($newId, Agent::class));
            }
        }

        /** @var ThreadMetadata $meta */
        foreach ($messageDB->getThread()->getAllMetadata() as $meta) {
            if ($meta->getParticipant()->getId() != $this->getCurrentUser()->getId() &&
                $meta->getParticipant()->getId() != ($newId = $message->getParticipants()[0]->getId())
            ) {
                $meta->setParticipant($this->repository->getReferenceForClass($newId, Agent::class));
            }
        }

        /** File management */
        $oldFile = null;
        if ((!$message->getFile() || !$message->getFile()->getId()) && $messageDB->getFile()) {
            $oldFile = $messageDB->getFile();
            $oldFile->getName(); // fucking proxy
        }
        if ($message->getFile() && $message->getFile()->getId() === 0) {
            $message->getFile()->setId(null);
        }
        if ($message->getFile() && !$message->getFile()->getId() && !$this->saveMedia($message)) {
            return array(AgentApiResponse::MESSAGES_UNSUPPORTED_FORMAT);
        }

        $messageDB->setFile($message->getFile());
        $result = $this->repository->editMessage($messageDB);

        if ($result instanceof \Exception) {
            /** @var File $file */
            if ($file = $message->getFile()) {
                $file->deleteFile();
            }

            return array(AgentApiResponse::ERROR_RESPONSE($result));
        }

        if ($oldFile) {
            $oldFile->deleteFile();
        }

        // SENDING NOTIFICATION IF IT ISN'T DRAFT
        if( !$message->isIsDraft() ){
            /** @var Agent $user */
            $user = $this->getCurrentUser();
            $userRecipient =  $message->getParticipantsFromMeta()[0]->getId() == $user->getId() ? $message->getParticipantsFromMeta()[1] : $message->getParticipantsFromMeta()[0];
//            if( in_array('optionMessage', $userRecipient->getNotifications()) ){
                $notification = NotificationManager::createNewMessageNotification($messageDB);
                $event = new NotificationEvent();
                $event->setMessage($messageDB);
                $event->addNotification($notification);

                $this->eventDispatcher->dispatch(NotificationEvents::ON_NOTIFICATION_ACTION, $event);
//            }
        }

        return $this->serializeMessage($messageDB);

    }

    /**
     * @param null $id
     * @return mixed
     */
    public function deleteResource($id)
    {
        // TODO: Implement deleteResource() method.
    }

    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
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
