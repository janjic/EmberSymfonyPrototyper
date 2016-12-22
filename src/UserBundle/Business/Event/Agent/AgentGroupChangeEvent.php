<?php

namespace UserBundle\Business\Event\Agent;

use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Group;

/**
 * Class AgentGroupChangeEvent
 * @package UserBundle\Business\Event\Agent
 */
class AgentGroupChangeEvent extends Event
{

    /**
     * @var Agent
     */
    protected $agent;

    /**
     * @var Group
     */
    protected $oldGroup;

    /**
     * @var boolean
     */
    protected $isSuspended;

    /**
     * AgentGroupChangeEvent constructor.
     * @param Agent        $agent
     * @param Group|null   $oldGroup
     * @param boolean|null $isSuspended
     */
    public function __construct(Agent $agent, $oldGroup, $isSuspended)
    {
        $this->agent       = $agent;
        $this->oldGroup    = $oldGroup;
        $this->isSuspended = $isSuspended;
    }

    /**
     * @return Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param Agent $agent
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }

    /**
     * @return Group|null
     */
    public function getOldGroup()
    {
        return $this->oldGroup;
    }

    /**
     * @param Group|null $oldGroup
     */
    public function setOldGroup($oldGroup)
    {
        $this->oldGroup = $oldGroup;
    }

    /**
     * @return boolean|null
     */
    public function isIsSuspended()
    {
        return $this->isSuspended;
    }

    /**
     * @param boolean|null $isSuspended
     */
    public function setIsSuspended($isSuspended)
    {
        $this->isSuspended = $isSuspended;
    }


}