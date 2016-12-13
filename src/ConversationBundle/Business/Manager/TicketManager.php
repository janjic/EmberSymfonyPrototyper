<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Manager\Ticket\JsonApiDeleteTicketManagerTrait;
use ConversationBundle\Business\Manager\Ticket\JsonApiGetTicketManagerTrait;
use ConversationBundle\Business\Manager\Ticket\JsonApiSaveTicketManagerTrait;
use ConversationBundle\Business\Manager\Ticket\JsonApiUpdateTicketManagerTrait;
use ConversationBundle\Business\Repository\MessageRepository;
use ConversationBundle\Business\Repository\TicketRepository;
use ConversationBundle\Entity\Thread;
use ConversationBundle\Entity\Ticket;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
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

    /**
     * @var MessageRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @param TicketRepository $repository
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(TicketRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository   = $repository;
        $this->fSerializer  = $fSerializer;
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeTicket($content, $mappings = null)
    {
        $relations = ['createdBy', 'forwardedTo', 'file', 'thread'];
        if (!$mappings) {
            $mappings = array(
                'createdBy' => array('class' => Agent::class, 'type'=>'agents'),
                'forwardedTo' => array('class' => Agent::class, 'type'=>'agents'),
                'file' => array('class' => File::class, 'type'=>'files'),
                'thread' => array('class' => Thread::class, 'type'=>'threads'),
            );
        }

        return $this->fSerializer->setDeserializationClass(Ticket::class)->deserialize($content, $mappings, $relations);
    }
//
//    /**
//     * @param $content
//     * @param null $mappings
//     * @return mixed
//     */
//    public function serializeGroup($content, $mappings = null)
//    {
//        $relations = array('roles');
//        if (!$mappings) {
//            $mappings = array(
//                'group'  => array('class' => Group::class, 'type'=>'groups'),
//                'roles'  => array('class' => Role::class, 'type'=>'roles')
//            );
//        }
//
//        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
//    }
}