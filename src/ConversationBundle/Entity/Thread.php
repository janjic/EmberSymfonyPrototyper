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
     * @ORM\OneToMany(targetEntity="Message", mappedBy="thread")
     * @var Message[]|Collection
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity="ThreadMetadata", mappedBy="thread", cascade={"all"})
     * @var ThreadMetadata[]|Collection
     */
    protected $metadata;

    protected $toBeDeleted = false;

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
    public function isToBeDeleted()
    {
        return $this->toBeDeleted;
    }

    /**
     * @param boolean $toBeDeleted
     */
    public function setToBeDeleted($toBeDeleted)
    {
        $this->toBeDeleted = $toBeDeleted;
    }

}