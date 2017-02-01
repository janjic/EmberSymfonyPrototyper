<?php

namespace PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PaymentBundle\Business\Manager\PaymentInfoManager;
use UserBundle\Entity\Agent;
use PaymentBundle\Model\Resource\CSVEntityInterface;
use PaymentBundle\Model\Resource\PrimaryKeyInterface;

/**
 * Class PaymentInfo
 * @package PaymentBundle\Entity
 * @ORM\Entity(repositoryClass="PaymentBundle\Business\Repository\PaymentInfoRepository")
 * @ORM\Table(name="as_payment_info")
 */
class PaymentInfo implements PrimaryKeyInterface, CSVEntityInterface
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
    protected $packagesValue = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $packagesPercentage = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $packagesCommission = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $connectValue = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $connectPercentage = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $connectCommission = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $setupFeeValue = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $setupFeePercentage = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $setupFeeCommission = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $streamValue = 0;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $streamPercentage = 0;

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
     * @ORM\Column(type="string", length=255, nullable=true)
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

    /**
     * @return float
     */
    public function getBonusValue()
    {
        return $this->bonusValue;
    }

    /**
     * @param float $bonusValue
     */
    public function setBonusValue($bonusValue)
    {
        $this->bonusValue = $bonusValue;
    }

    /**
     * @return String
     */
    public function getBonusDesc()
    {
        return $this->bonusDesc;
    }

    /**
     * @param String $bonusDesc
     */
    public function setBonusDesc($bonusDesc)
    {
        $this->bonusDesc = $bonusDesc;
    }

    /**
     * @return array
     */
    public function getCSVHeader()
    {
        return array(
            'id of payment',
            'Agent\'s FullName',
            'Agent\'s Bank Name',
            'Agent\'s Bank Account',
            'orderId',
            'customerId',
            'Package\'s Value',
            'Package\'s Percentage',
            'Package\'s Commission',
            'Connect Value',
            'Connect Percentage',
            'Connect Commission',
            'Setup Fee Value',
            'Setup Fee Percentage',
            'Setup Fee Commission',
            'Stream Value',
            'Stream Percentage',
            'Stream Commission',
            'Total Commission',
            'Bonus Value',
            'Bonus Desc',
            'Payment Type',
            'state',
            'Created At',
            'Payed At',
            'memo',
            'currency',
        );
    }

    /**
     * @return array
     */
    public function getCSVValues()
    {
        $values = array();
        foreach ($this->getCSVHeader() as $property) {
            switch ($property) {
                case 'id of payment':
                    $values[] = $this->getId();
                    break;
                case 'Agent\'s FullName':
                    $values[] =  $this->getAgent()->getLastName().' '.$this->getAgent()->getFirstName();
                    break;
                case 'Agent\'s Bank Name':
                    $values[] =  $this->getAgent()->getBankName();
                    break;
                case 'Agent\'s Bank Account':
                    $values[] =  $this->getAgent()->getBankAccountNumber();
                    break;
                case 'Package\'s Value':
                    $values[] =  $this->getPackagesValue();
                    break;
                case 'Package\'s Percentage':
                    $values[] =  $this->getPackagesPercentage();
                    break;
                case 'Package\'s Commission':
                    $values[] =  $this->getPackagesCommission();
                    break;
                case 'Connect Value':
                    $values[] =  $this->getConnectValue();
                    break;
                case 'Connect Percentage':
                    $values[] =  $this->getConnectPercentage();
                    break;
                case 'Connect Commission':
                    $values[] =  $this->getConnectCommission();
                    break;
                case 'Setup Fee Value':
                    $values[] =  $this->getSetupFeeValue();
                    break;
                case 'Setup Fee Percentage':
                    $values[] =  $this->getSetupFeePercentage();
                    break;
                case 'Setup Fee Commission':
                    $values[] =  $this->getSetupFeeCommission();
                    break;
                case 'Stream Value':
                    $values[] =  $this->getStreamValue();
                    break;
                case 'Stream Percentage':
                    $values[] =  $this->getStreamPercentage();
                    break;
                case 'Stream Commission':
                    $values[] =  $this->getStreamCommission();
                    break;
                case 'Total Commission':
                    $values[] =  $this->getTotalCommission();
                    break;
                case 'Bonus Value':
                    $values[] =  $this->getBonusValue();
                    break;
                case 'Bonus Desc':
                    $values[] =  $this->getBonusDesc();
                    break;
                case 'Payment Type':
                    $values[] =  $this->generatePaymentTypeResponse($this->getPaymentType());
                    break;
                case 'Created At':
                    $this->getCreatedAt() ? $values[] =  $this->getCreatedAt()->format('Y-m-d') : $values[] = '';
                    break;
                case ('Payed At'):
                    $this->getPayedAt() ? $values[]  =  $this->getPayedAt()->format('Y-m-d'): $values[] = '';
                    break;
                default:
                    $values[] = $this->{$property};
                    break;
            }
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function setCSVValues($csvRow, $locale, $csvHeaders, $propertyMappings = array())
    {
        return $this;
    }

    public function generatePaymentTypeResponse($paymentType)
    {
        switch ($paymentType){
            case PaymentInfoManager::COMMISSION_TYPE:
                return 'Commission';
            case PaymentInfoManager::BONUS_TYPE:
                return 'Bonus';
            default:
                return 'N/A';
        }
    }
}