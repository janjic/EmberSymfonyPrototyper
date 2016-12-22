<?php

namespace UserBundle\Business\Event\Notification;

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
     * NotificationEvent constructor.
     */
    public function __construct()
    {
        $this->notification = [];
    }

    /**
     * @return Notification
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
}