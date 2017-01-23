<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Notification
 * @package UserBundle\Entity
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\NotificationRepository")
 * @ORM\Table(name="as_notification")
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="ConversationBundle\Entity\Message")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $message;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length = 30, nullable=true)
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(name="created_at", type="datetime", length=255, nullable=true)
     */
    protected $createdAt;

    /**
     * @var boolean
     * @ORM\Column(name="is_seen", type="boolean")
     */
    protected $isSeen = false;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @ORM\JoinColumn(name="new_agent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $newAgent;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentBundle\Entity\PaymentInfo")
     * @ORM\JoinColumn(name="payment_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $payment;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $agent;

    /**
     * @ORM\Column(name="link", type="string", length= 70, nullable=true)
     */
    protected $link;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return boolean
     */
    public function isIsSeen()
    {
        return $this->isSeen;
    }

    /**
     * @param boolean $isSeen
     */
    public function setIsSeen($isSeen)
    {
        $this->isSeen = $isSeen;
    }

    /**
     * @return mixed
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param mixed $agent
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

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
     * @return mixed
     */
    public function getNewAgent()
    {
        return $this->newAgent;
    }

    /**
     * @param mixed $newAgent
     */
    public function setNewAgent($newAgent)
    {
        $this->newAgent = $newAgent;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }


}