<?php

namespace UserBundle\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Bonus
 * @package UserBundle\Entity\Settings
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\BonusRepository")
 * @ORM\Table(name="as_bonus")
 */
class Bonus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Settings\Settings", inversedBy="bonuses")
     * @@ORM\JoinColumn(name="settings_id", referencedColumnName="id")
     */
    protected $settings;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Group")
     * @@ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(name="amount", type="float")
     */
    protected $amount;

    /**
     * @ORM\Column(name="currency", type="string", length=255)
     */
    protected $currency;

    /**
     * @ORM\Column(name="number_of_customers", type="integer")
     */
    protected $numberOfCustomers;

    /**
     * @ORM\Column(name="period", type="integer")
     */
    protected $period;

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
     * @return mixed
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param mixed $settings
     * @return $this
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getNumberOfCustomers()
    {
        return $this->numberOfCustomers;
    }

    /**
     * @param mixed $numberOfCustomers
     * @return $this
     */
    public function setNumberOfCustomers($numberOfCustomers)
    {
        $this->numberOfCustomers = $numberOfCustomers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param mixed $period
     * @return $this
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}