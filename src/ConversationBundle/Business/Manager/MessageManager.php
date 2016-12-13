<?php

namespace ConversationBundle\Business\Manager;

use ConversationBundle\Business\Manager\Message\JsonApiDeleteMessageManagerTrait;
use ConversationBundle\Business\Manager\Message\JsonApiGetMessageManagerTrait;
use ConversationBundle\Business\Manager\Message\JsonApiSaveMessageManagerTrait;
use ConversationBundle\Business\Manager\Message\JsonApiUpdateMessageManagerTrait;
use ConversationBundle\Business\Repository\MessageRepository;
use ConversationBundle\Entity\Message;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Entity\Agent;


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
     * @param MessageRepository $repository
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(MessageRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository   = $repository;
        $this->fSerializer  = $fSerializer;
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeMessage($content, $mappings = null)
    {
        $relations = array('sender');
//        $relations = [];
        if (!$mappings) {
            $mappings = array(
                'message' => array('class' => Message::class, 'type'=>'messages'),
                'sender' => array('class' => Agent::class, 'type'=>'agents')
            );
        }

        return $this->fSerializer->setDeserializationClass(Message::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function serializeGroup($content, $mappings = null)
    {
        $relations = array('roles');
        if (!$mappings) {
            $mappings = array(
                'group'  => array('class' => Group::class, 'type'=>'groups'),
                'roles'  => array('class' => Role::class, 'type'=>'roles')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
    }
}