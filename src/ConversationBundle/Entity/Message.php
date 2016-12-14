<?php

namespace ConversationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Entity\Message as BaseMessage;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * @ORM\Entity(repositoryClass="ConversationBundle\Business\Repository\MessageRepository")
 * @ORM\Table(name="as_message")
 */
class Message extends BaseMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="messages", cascade={"persist", "merge"})
     * @var ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @var ParticipantInterface
     */
    protected $sender;

    /**
     * @ORM\OneToMany(targetEntity="MessageMetadata", mappedBy="message", cascade={"all"})
     * @var MessageMetadata[]|Collection
     */
    protected $metadata;

    protected $participants;

    protected $messageSubject;

    /**
     * Message constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->participants = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @return mixed
     */
    public function getParticipantsFromMeta()
    {
        foreach ($this->metadata as $metadata) {
            $this->participants[] = $metadata->getParticipant();
        }

        return $this->participants;
    }

    /**
     * @param mixed $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    /**
     * @return mixed
     */
    public function getMessageSubject()
    {
        return $this->messageSubject;
    }

    /**
     * @param mixed $messageSubject
     */
    public function setMessageSubject($messageSubject)
    {
        $this->messageSubject = $messageSubject;
    }


}