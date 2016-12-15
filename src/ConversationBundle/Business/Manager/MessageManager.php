<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Manager\Message\JsonApiSaveMessageManagerTrait;
use ConversationBundle\Business\Repository\MessageRepository;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\Serializer\JsonApiMany;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
    public function serializeMessage($content, $mappings = null)
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

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
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