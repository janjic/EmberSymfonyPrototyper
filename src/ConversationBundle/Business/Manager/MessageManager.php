<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Event\Thread\ThreadEvents;
use ConversationBundle\Business\Event\Thread\ThreadReadEvent;
use ConversationBundle\Business\Manager\Message\JsonApiSaveMessageManagerTrait;
use ConversationBundle\Business\Repository\MessageRepository;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\Serializer\JsonApiMany;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * @param MessageRepository        $repository
     * @param FJsonApiSerializer       $fSerializer
     * @param MessageComposer          $messageComposer
     * @param MessageSender            $messageSender
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(MessageRepository $repository, FJsonApiSerializer $fSerializer, MessageComposer $messageComposer,
                                MessageSender $messageSender, EventDispatcherInterface $eventDispatcher)
    {
        $this->repository       = $repository;
        $this->fSerializer      = $fSerializer;
        $this->messageComposer  = $messageComposer;
        $this->messageSender    = $messageSender;
        $this->eventDispatcher  = $eventDispatcher;
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
     * @param $data
     * @return mixed
     */
    public function updateResource($data)
    {
        // TODO: Implement updateResource() method.
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function deleteResource($id)
    {
        // TODO: Implement deleteResource() method.
    }
}
