<?php

namespace ConversationBundle\Business\Event\Thread;

use ConversationBundle\Entity\Thread;
use FOS\MessageBundle\Model\ThreadInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ThreadReadEvent
 * @package ConversationBundle\Business\Event\Thread
 */
class ThreadReadEvent extends Event
{

    /**
     * @var Thread
     */
    protected $thread;

    /**
     * ThreadReadEvent constructor.
     * @param ThreadInterface $thread
     */
    public function __construct(ThreadInterface $thread)
    {
        $this->thread = $thread;
    }

    /**
     * @return Thread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * @param Thread $thread
     */
    public function setThread($thread)
    {
        $this->thread = $thread;
    }

}