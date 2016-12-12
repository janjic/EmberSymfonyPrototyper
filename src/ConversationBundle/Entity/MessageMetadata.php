<?php

namespace ConversationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\MessageMetadata as BaseMessageMetadata;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="as_message_metadata")
 */
class MessageMetadata extends BaseMessageMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="metadata")
     * @var MessageInterface
     */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @var ParticipantInterface
     */
    protected $participant;
}