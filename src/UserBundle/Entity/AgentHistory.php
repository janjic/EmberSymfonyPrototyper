<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AgentHistory
 * @package UserBundle\Entity
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\AgentHistoryRepository")
 * @ORM\Table(name="as_agent_history")
 */
class AgentHistory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $agent;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @ORM\JoinColumn(name="changed_by_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $changedByAgent;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Group")
     * @ORM\JoinColumn(name="from_group_id", referencedColumnName="id", nullable=true)
     */
    protected $changedFrom;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Group")
     * @ORM\JoinColumn(name="to_group_id", referencedColumnName="id", nullable=true)
     */
    protected $changedTo;

    /**
     * If true agent has been suspended, if false agent is no longer suspended
     * @ORM\Column(name="changed_to_suspended", type="boolean", nullable=true)
     */
    protected $changedToSuspended;

    /**
     * @ORM\Column(name="change_type", type="string")
     */
    protected $changedType;

    /**
     * @var string
     * @ORM\Column(name="date", type="datetime", length=255, nullable=true)
     */
    protected $date;


    public function __construct()
    {
        $this->date = new \DateTime();
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
    public function getChangedByAgent()
    {
        return $this->changedByAgent;
    }

    /**
     * @param mixed $changedByAgent
     */
    public function setChangedByAgent($changedByAgent)
    {
        $this->changedByAgent = $changedByAgent;
    }

    /**
     * @return mixed
     */
    public function getChangedFrom()
    {
        return $this->changedFrom;
    }

    /**
     * @param mixed $changedFrom
     */
    public function setChangedFrom($changedFrom)
    {
        $this->changedFrom = $changedFrom;
    }

    /**
     * @return mixed
     */
    public function getChangedTo()
    {
        return $this->changedTo;
    }

    /**
     * @param mixed $changedTo
     */
    public function setChangedTo($changedTo)
    {
        $this->changedTo = $changedTo;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getChangedToSuspended()
    {
        return $this->changedToSuspended;
    }

    /**
     * @param mixed $changedToSuspended
     */
    public function setChangedToSuspended($changedToSuspended)
    {
        $this->changedToSuspended = $changedToSuspended;
    }

    /**
     * @return mixed
     */
    public function getChangedType()
    {
        return $this->changedType;
    }

    /**
     * @param mixed $changedType
     */
    public function setChangedType($changedType)
    {
        $this->changedType = $changedType;
    }
}