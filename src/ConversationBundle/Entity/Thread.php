<?php

namespace ConversationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Entity\Thread as BaseThread;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * @ORM\Entity(repositoryClass="ConversationBundle\Business\Repository\ThreadRepository")
 * @ORM\Table(name="as_thread")
 */
class Thread extends BaseThread
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @var ParticipantInterface
     */
    protected $createdBy;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="thread", cascade={"persist"})
     * @var Message[]|Collection
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity="ThreadMetadata", mappedBy="thread", cascade={"all"})
     * @var ThreadMetadata[]|Collection
     */
    protected $metadata;

    /**
     * Property used to determine if delete property should be changed
     * @var bool
     */
    protected $changeDeleted = false;

    /**
     * Property used to determine if thread has been read by current participant
     * @var bool
     */
    protected $isRead;

    /**
     * Thread constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTime();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return boolean
     */
    public function isChangeDeleted()
    {
        return $this->changeDeleted;
    }

    /**
     * @param boolean $changeDeleted
     */
    public function setChangeDeleted($changeDeleted)
    {
        $this->changeDeleted = $changeDeleted;
    }

    /**
     * If thread is fully read
     * @param ParticipantInterface $participant
     * @return mixed
     */
    public function isReadByParticipantCustom(ParticipantInterface $participant)
    {
        /** @var ThreadMetadata $meta */
        $meta = $this->getMetadataForParticipant($participant);
        if ($meta) {
            return $meta->isIsReadByParticipant();
        }

        return false;
    }

    /**
     * If thread is fully read
     * @param ParticipantInterface $participant
     */
    public function setAsUnreadForOtherParticipants(ParticipantInterface $participant)
    {
        /** @var ThreadMetadata $meta */
        foreach ($this->getAllMetadata() as $meta) {
            if ($meta->getParticipant()->getId() != $participant->getId()) {
                $meta->setIsReadByParticipant(false);
            } else {
                $meta->setIsReadByParticipant(true);
            }
        }
    }

    /**
     * @return boolean
     */
    public function isIsRead()
    {
        return $this->isRead;
    }

    /**
     * @param boolean $isRead
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }

}