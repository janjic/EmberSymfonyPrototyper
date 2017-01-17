<?php

namespace PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\Agent;

/**
 * Class PaymentInfo
 * @package PaymentBundle\Entity
 * @ORM\Entity(repositoryClass="PaymentBundle\Business\Repository\PaymentInfoRepository")
 * @ORM\Table(name="as_payment_info")
 */
class PaymentInfo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Agent
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $agent;

    /**
     * Which role agent had when payment was created
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $agentRole;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $orderId;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="customer_id", nullable=true)
     */
    protected $customerId;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $packagesValue;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $packagesPercentage;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $packagesCommission = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $connectValue;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $connectPercentage;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $connectCommission = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $setupFeeValue;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $setupFeePercentage;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $setupFeeCommission = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $streamValue;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $streamPercentage;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $streamCommission = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $totalCommission = 0;

    /**
     * @var float
     * @ORM\Column(type="float", options={"default": 0})
     */
    protected $bonusValue = 0;

    /**
     * @var String
     * @ORM\Column(type="string", length=255)
     */
    protected $bonusDesc;

    /**
     * NULL - unprocessed payment, FALSE - rejected payment, TRUE - approved payment
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $state;

    /**
     * Is payment commission or bonus
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $paymentType;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="payed_at", type="datetime", nullable=true)
     */
    protected $payedAt;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $memo;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $currency;

    /**
     * PaymentInfo constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return $this
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPackagesValue()
    {
        return $this->packagesValue;
    }

    /**
     * @param mixed $packagesValue
     * @return $this
     */
    public function setPackagesValue($packagesValue)
    {
        $this->packagesValue = $packagesValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getPackagesPercentage()
    {
        return $this->packagesPercentage;
    }

    /**
     * @param float $packagesPercentage
     * @return $this
     */
    public function setPackagesPercentage($packagesPercentage)
    {
        $this->packagesPercentage = $packagesPercentage;

        return $this;
    }

    /**
     * @return float
     */
    public function getPackagesCommission()
    {
        return $this->packagesCommission;
    }

    /**
     * @param float $packagesCommission
     * @return $this
     */
    public function setPackagesCommission($packagesCommission)
    {
        $this->packagesCommission = $packagesCommission;

        return $this;
    }

    /**
     * @return float
     */
    public function getConnectValue()
    {
        return $this->connectValue;
    }

    /**
     * @param float $connectValue
     * @return $this
     */
    public function setConnectValue($connectValue)
    {
        $this->connectValue = $connectValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getConnectPercentage()
    {
        return $this->connectPercentage;
    }

    /**
     * @param float $connectPercentage
     * @return $this
     */
    public function setConnectPercentage($connectPercentage)
    {
        $this->connectPercentage = $connectPercentage;

        return $this;
    }

    /**
     * @return float
     */
    public function getConnectCommission()
    {
        return $this->connectCommission;
    }

    /**
     * @param float $connectCommission
     * @return $this
     */
    public function setConnectCommission($connectCommission)
    {
        $this->connectCommission = $connectCommission;

        return $this;
    }

    /**
     * @return float
     */
    public function getSetupFeeValue()
    {
        return $this->setupFeeValue;
    }

    /**
     * @param float $setupFeeValue
     * @return $this
     */
    public function setSetupFeeValue($setupFeeValue)
    {
        $this->setupFeeValue = $setupFeeValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getSetupFeePercentage()
    {
        return $this->setupFeePercentage;
    }

    /**
     * @param float $setupFeePercentage
     * @return $this
     */
    public function setSetupFeePercentage($setupFeePercentage)
    {
        $this->setupFeePercentage = $setupFeePercentage;

        return $this;
    }

    /**
     * @return float
     */
    public function getSetupFeeCommission()
    {
        return $this->setupFeeCommission;
    }

    /**
     * @param float $setupFeeCommission
     * @return $this
     */
    public function setSetupFeeCommission($setupFeeCommission)
    {
        $this->setupFeeCommission = $setupFeeCommission;

        return $this;
    }

    /**
     * @return float
     */
    public function getStreamValue()
    {
        return $this->streamValue;
    }

    /**
     * @param float $streamValue
     * @return $this
     */
    public function setStreamValue($streamValue)
    {
        $this->streamValue = $streamValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getStreamPercentage()
    {
        return $this->streamPercentage;
    }

    /**
     * @param float $streamPercentage
     * @return $this
     */
    public function setStreamPercentage($streamPercentage)
    {
        $this->streamPercentage = $streamPercentage;

        return $this;
    }

    /**
     * @return float
     */
    public function getStreamCommission()
    {
        return $this->streamCommission;
    }

    /**
     * @param float $streamCommission
     * @return $this
     */
    public function setStreamCommission($streamCommission)
    {
        $this->streamCommission = $streamCommission;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalCommission()
    {
        return $this->totalCommission;
    }

    /**
     * Set total as sum
     * @return $this
     */
    public function setTotalCommission()
    {
        $this->totalCommission = $this->packagesCommission + $this->connectCommission + $this->setupFeeCommission + $this->streamCommission;

        return $this;
    }

    /**
     * Calculate all commissions
     * @return $this
     */
    public function calculateCommissions()
    {
        if ($this->packagesValue && $this->packagesPercentage) {
            $this->packagesCommission = $this->packagesValue * ($this->packagesPercentage / 100);
        }

        if ($this->connectValue && $this->connectPercentage) {
            $this->connectCommission = $this->connectValue * ($this->connectPercentage / 100);
        }

        if ($this->setupFeeValue && $this->setupFeePercentage) {
            $this->setupFeeCommission = $this->setupFeeValue * ($this->setupFeePercentage / 100);
        }

        if ($this->streamValue && $this->streamPercentage) {
            $this->streamCommission = $this->streamValue * ($this->streamPercentage / 100);
        }

        return $this->setTotalCommission();
    }

    /**
     * @return boolean
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param boolean $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getPayedAt()
    {
        return $this->payedAt;
    }

    /**
     * @param \DateTime $payedAt
     */
    public function setPayedAt($payedAt)
    {
        $this->payedAt = $payedAt;
    }

    /**
     * @return string
     */
    public function getAgentRole()
    {
        return $this->agentRole;
    }

    /**
     * @param string $agentRole
     */
    public function setAgentRole($agentRole)
    {
        $this->agentRole = $agentRole;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
}