<?php

namespace ConversationBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ThreadInterface;
use UserBundle\Entity\Agent;

/**
 * @ORM\Entity(repositoryClass="ConversationBundle\Business\Repository\TicketRepository")
 * @ORM\Table(name="as_ticket")
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length = 30, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    protected $text;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length = 30, nullable=true)
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length = 30, nullable=true)
     */
    protected $status;

    /**
     * @var string
     * @ORM\Column(name="created_at", type="datetime", length=255, nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Document\File", cascade={"all"}, orphanRemoval=TRUE)
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    protected $file;

    /**
     * @ORM\OneToOne(targetEntity="Thread", inversedBy="ticket", cascade={"persist"})
     * @ORM\JoinColumn(name="threadid", referencedColumnName="id", nullable=true)
     * @var ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @ORM\JoinColumn(name="forwarded_to_id", referencedColumnName="id", onDelete="SET NULL")
     * @var Agent
     */
    protected $forwardedTo;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="id", onDelete="CASCADE")
     * @var Agent
     */
    protected $createdBy;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        if (!($createdAt instanceof DateTime)) {
            $createdAt = new DateTime($createdAt);
    }
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return ThreadInterface
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * @param ThreadInterface $thread
     */
    public function setThread($thread)
    {
        $this->thread = $thread;
    }

    /**
     * @return Agent
     */
    public function getForwardedTo()
    {
        return $this->forwardedTo;
    }

    /**
     * @param Agent $forwardedTo
     */
    public function setForwardedTo($forwardedTo)
    {
        $this->forwardedTo = $forwardedTo;
    }

    /**
     * @return Agent
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param Agent $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }


}