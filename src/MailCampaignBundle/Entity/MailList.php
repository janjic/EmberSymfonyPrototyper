<?php

namespace MailCampaignBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ThreadInterface;
use UserBundle\Entity\Agent;

/**
 * Class MailList
 * @package MailCampaignBundle\Entity
 */
class MailList
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $fromName;

    /**
     * @var string
     */
    protected $fromAddress;

    /**
     * @var string
     */
    protected $note;

    /**
     * @var
     */
    protected $subscribers;

    /**
     * @var
     */
    protected $subscribersCount;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromAddress()
    {
        return $this->fromAddress;
    }

    /**
     * @param $fromAddress
     * @return $this
     */
    public function setFromAddress($fromAddress)
    {
        $this->fromAddress = $fromAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }

    /**
     * @param mixed $subscribers
     */
    public function setSubscribers($subscribers)
    {
        $this->subscribers = $subscribers;
    }

    /**
     * @param Agent $subscriber
     */
    public function addSubscriber(Agent $subscriber){
        $this->subscribers[] = $subscriber;
    }


    public function __construct(){
        $this->subscribers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getSubscribersCount()
    {
        return $this->subscribersCount;
    }

    /**
     * @param mixed $subscribersCount
     */
    public function setSubscribersCount($subscribersCount)
    {
        $this->subscribersCount = $subscribersCount;
    }


}