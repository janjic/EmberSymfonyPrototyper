<?php

namespace UserBundle\Business\Event\Agent;

use UserBundle\Business\Manager\AgentHistoryManager;

/**
 * Class ThreadReadListener
 * @package UserBundle\Business\Event\Agent
 */
class AgentGroupChangeListener
{
    /**
     * @var AgentGroupChangeEvent
     */
    protected $event;

    /**
     * @var AgentHistoryManager
     */
    protected $manager;

    /**
     * ThreadReadListener constructor.
     * @param AgentHistoryManager $manager
     */
    public function __construct(AgentHistoryManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param AgentGroupChangeEvent|null $event
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
            $this->manager->saveChangeHistory($this->event->getAgent(), $this->event->getOldGroup(), $this->event->isIsSuspended(), $this->event->getActiveAgentsNumb(), $this->event->getNumbOfSales());
        }
    }

}