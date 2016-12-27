<?php

namespace ConversationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\ThreadMetadata as BaseThreadMetadata;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="as_thread_metadata")
 */
class ThreadMetadata extends BaseThreadMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="metadata")
     * @var ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @ORM\JoinColumn(name="participant_id", referencedColumnName="id", onDelete="CASCADE")
     * @var ParticipantInterface
     */
    protected $participant;

    /**
     * Custom field used for optimization
     * @var boolean
     * @ORM\Column(name="is_read_by_participant", type="boolean")
     */
    protected $isReadByParticipant = false;

    /**
     * @return boolean
     */
    public function isIsReadByParticipant()
    {
        return $this->isReadByParticipant;
    }

    /**
     * @param boolean $isReadByParticipant
     */
    public function setIsReadByParticipant($isReadByParticipant)
    {
        $this->isReadByParticipant = $isReadByParticipant;
    }


}