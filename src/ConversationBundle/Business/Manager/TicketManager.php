<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Manager\Ticket\JsonApiDeleteTicketManagerTrait;
use ConversationBundle\Business\Manager\Ticket\JsonApiGetTicketManagerTrait;
use ConversationBundle\Business\Manager\Ticket\JsonApiJQGridTicketManagerTrait;
use ConversationBundle\Business\Manager\Ticket\JsonApiSaveTicketManagerTrait;
use ConversationBundle\Business\Manager\Ticket\JsonApiUpdateTicketManagerTrait;
use ConversationBundle\Business\Repository\TicketRepository;
use ConversationBundle\Entity\Thread;
use ConversationBundle\Entity\Ticket;
use ConversationBundle\Util\TicketSerializerInfo;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Exception;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;
use FOS\MessageBundle\Composer\Composer as MessageComposer;
use FOS\MessageBundle\Sender\Sender as MessageSender;

/**
 * Class TicketManager
 * @package ConversationBundle\Business\Manager
 */
class TicketManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiSaveTicketManagerTrait;
    use JsonApiGetTicketManagerTrait;
    use JsonApiUpdateTicketManagerTrait;
    use JsonApiDeleteTicketManagerTrait;
    use JsonApiJQGridTicketManagerTrait;

    /**
     * @var TicketRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @var AgentManager $agentManager
     */
    protected $agentManager;

    /**
     * @var TokenStorage $tokenStorage
     */
    protected $tokenStorage;

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
     * @param TicketRepository         $repository
     * @param FJsonApiSerializer       $fSerializer
     * @param AgentManager             $agentManager
     * @param TokenStorage             $tokenStorage
     * @param MessageComposer          $messageComposer
     * @param MessageSender            $messageSender
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(TicketRepository $repository, FJsonApiSerializer $fSerializer, AgentManager $agentManager,
                                TokenStorage $tokenStorage, MessageComposer $messageComposer, MessageSender $messageSender,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->repository      = $repository;
        $this->fSerializer     = $fSerializer;
        $this->agentManager    = $agentManager;
        $this->tokenStorage    = $tokenStorage;
        $this->messageComposer = $messageComposer;
        $this->messageSender   = $messageSender;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Placeholder for thread save result
     */
    protected $saveEventResult;

    /**
     * @param Ticket $ticket
     * @return Ticket|Exception
     */
    public function save(Ticket $ticket)
    {
        $ticket = $this->repository->saveTicket($ticket);

        return $ticket;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTicketById($id)
    {
        return $this->repository->findTicketById($id);
    }


    /**
     * @param $tickets
     * @return mixed
     * @internal param $content
     * @internal param null $mappings
     */
    public function serializeTicket($tickets)
    {
        return $this->fSerializer->setType('tickets')->setDeserializationClass(Agent::class)->serialize($tickets, TicketSerializerInfo::$mappings, TicketSerializerInfo::$relations, array(), AgentSerializerInfo::$basicFields);

    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeTicket($content, $mappings = null)
    {
        return $this->fSerializer->setDeserializationClass(Ticket::class)->deserialize($content, TicketSerializerInfo::$mappings, TicketSerializerInfo::$relations);
    }

    public function getAgentById($id)
    {
        return $this->agentManager->findAgentById($id);
    }

    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}