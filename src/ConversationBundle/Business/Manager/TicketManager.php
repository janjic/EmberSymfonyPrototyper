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
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;


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
     * @param TicketRepository $repository
     * @param FJsonApiSerializer $fSerializer
     * @param AgentManager $agentManager
     */
    public function __construct(TicketRepository $repository, FJsonApiSerializer $fSerializer, AgentManager $agentManager)
    {
        $this->repository   = $repository;
        $this->fSerializer  = $fSerializer;
        $this->agentManager = $agentManager;
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

    /**
     * @param Ticket $ticket
     * @return Ticket|Exception
     */
    public function save(Ticket $ticket)
    {
        $ticket = $this->repository->saveTicket($ticket);

        if ($ticket instanceof Exception) {
            return $ticket;
        }

        return $ticket;
    }


    /**
     * @param $tickets
     * @return mixed
     * @internal param $content
     * @internal param null $mappings
     */
    public function serializeTicket($tickets)
    {
        return $this->fSerializer->setType('tickets')->setDeserializationClass(Agent::class)->serialize($tickets, TicketSerializerInfo::$mappings, TicketSerializerInfo::$relations);

    }
}