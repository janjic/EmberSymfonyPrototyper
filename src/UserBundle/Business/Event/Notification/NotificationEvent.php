<?php

namespace UserBundle\Business\Event\Notification;

use FOS\MessageBundle\Model\MessageInterface;
use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\Notification;

/**
 * Class NotificationEvent
 * @package UserBundle\Business\Event\Notification
 */
class NotificationEvent extends Event
{
    /**
     * @var Notification
     */
    protected $notification;

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * NotificationEvent constructor.
     */
    public function __construct()
    {
        $this->notification = [];
    }

    /**
     * @return array
     */
    public function getNotifications()
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     */
    public function addNotification($notification)
    {
        $this->notification[] = $notification;
    }

    /**
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param MessageInterface $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }




}