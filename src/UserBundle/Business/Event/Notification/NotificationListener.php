<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 21.12.16.
 * Time: 15.10
 */

namespace UserBundle\Business\Event\Notification;

use UserBundle\Business\Manager\NotificationManager;

/**
 * Class NotificationListener
 * @package UserBundle\Business\Event\Notification
 */
class NotificationListener
{
    /**
     * @var NotificationEvent
     */
    protected $event;

    /**
     * @var NotificationManager
     */
    protected $manager;

    /**
     * ThreadReadListener constructor.
     * @param NotificationManager $manager
     */
    public function __construct(NotificationManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param NotificationEvent|null $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     *
     */
    public function execute()
    {
        if ($this->event) {
            $this->manager->saveNotifications($this->event);
        }
    }
}