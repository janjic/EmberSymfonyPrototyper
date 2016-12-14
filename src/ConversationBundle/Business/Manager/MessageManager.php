<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Manager\Message\JsonApiDeleteMessageManagerTrait;
use ConversationBundle\Business\Manager\Message\JsonApiGetMessageManagerTrait;
use ConversationBundle\Business\Manager\Message\JsonApiSaveMessageManagerTrait;
use ConversationBundle\Business\Manager\Message\JsonApiUpdateMessageManagerTrait;
use ConversationBundle\Business\Repository\MessageRepository;
use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Thread;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\Common\Util\Debug;
use FSerializerBundle\Serializer\JsonApiMany;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UserBundle\Entity\Agent;
use FOS\MessageBundle\Composer\Composer as MessageComposer;
use FOS\MessageBundle\Sender\Sender as MessageSender;
use FOS\MessageBundle\Provider\Provider as MessageProvider;

/**
 * Class MessageManager
 * @package ConversationBundle\Business\Manager
 */
class MessageManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiSaveMessageManagerTrait;
    use JsonApiGetMessageManagerTrait;
    use JsonApiUpdateMessageManagerTrait;
    use JsonApiDeleteMessageManagerTrait;

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
     * @var MessageProvider $messageProvider
     */
    protected $messageProvider;

    /**
     * @var EventDispatcherInterface $eventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @param MessageRepository        $repository
     * @param FJsonApiSerializer       $fSerializer
     * @param MessageComposer          $messageComposer
     * @param MessageSender            $messageSender
     * @param MessageProvider          $messageProvider
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(MessageRepository $repository, FJsonApiSerializer $fSerializer, MessageComposer $messageComposer,
                                MessageSender $messageSender, MessageProvider $messageProvider, EventDispatcherInterface $eventDispatcher)
    {
        $this->repository       = $repository;
        $this->fSerializer      = $fSerializer;
        $this->messageComposer  = $messageComposer;
        $this->messageSender    = $messageSender;
        $this->messageProvider  = $messageProvider;
        $this->eventDispatcher  = $eventDispatcher;
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeMessage($content, $mappings = null)
    {
        $relations = array('sender', 'participants');
        if (!$mappings) {
            $mappings = array(
                'message' => array('class' => Message::class, 'type'=>'messages'),
                'sender' => array('class' => Agent::class, 'type'=>'agents'),
                'participants' => array('class' => Agent::class, 'type'=>'agents', 'jsonApiType'=>JsonApiMany::class)
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
        $relations = array('thread');
        if (!$mappings) {
            $mappings = array(
                'message' => array('class' => Message::class, 'type'=>'messages'),
                'sender' => array('class' => Agent::class, 'type'=>'agents'),
                'thread' => array('class' => Thread::class, 'type'=>'threads'),
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
    }
}