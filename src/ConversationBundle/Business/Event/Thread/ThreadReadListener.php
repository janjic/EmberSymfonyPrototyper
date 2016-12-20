<?php

namespace ConversationBundle\Business\Event\Thread;
use ConversationBundle\Business\Manager\ThreadManager;

/**
 * Class ThreadReadListener
 * @package ConversationBundle\Business\Event\Thread
 */
class ThreadReadListener
{

    /**
     * @var ThreadReadEvent
     */
    protected $event;

    /**
     * @var ThreadManager
     */
    protected $manager;

    /**
     * ThreadReadListener constructor.
     * @param ThreadManager $manager
     */
    public function __construct(ThreadManager $manager)
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
            $this->manager->setAsRead($this->event->getThread());
        }
    }

}