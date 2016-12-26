<?php

namespace UserBundle\Business\Event\Notification;

use ConversationBundle\Business\Event\Thread\ThreadReadEvent;
use UserBundle\Business\Manager\NotificationManager;

/**
 * Class NotificationSeenListener
 * @package UserBundle\Business\Event\Notification
 */
class NotificationSeenListener
{
    /**
     * @var ThreadReadEvent
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
     * @param ThreadReadEvent|null $event
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
            $this->manager->updateNotificationsToSeen($this->event);
        }
    }
}