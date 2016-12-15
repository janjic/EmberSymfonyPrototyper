<?php

namespace UserBundle\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Commission
 * @package UserBundle\Entity\Settings
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\CommissionRepository")
 * @ORM\Table(name="as_commission")
 */
class Commission
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Settings\Settings", inversedBy="commissions")
     * @@ORM\JoinColumn(name="settings_id", referencedColumnName="id")
     */
    protected $settings;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Group")
     * @@ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @ORM\Column(name="setup_fee", type="float")
     */
    protected $setupFee;

    /**
     * @ORM\Column(name="packages", type="float")
     */
    protected $packages;

    /**
     * @ORM\Column(name="connect", type="float")
     */
    protected $connect;

    /**
     * @ORM\Column(name="stream", type="float")
     */
    protected $stream;

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
    public function getSetupFee()
    {
        return $this->setupFee;
    }

    /**
     * @param mixed $setupFee
     * @return $this
     */
    public function setSetupFee($setupFee)
    {
        $this->setupFee = $setupFee;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param mixed $packages
     * @return $this
     */
    public function setPackages($packages)
    {
        $this->packages = $packages;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConnect()
    {
        return $this->connect;
    }

    /**
     * @param mixed $connect
     * @return $this
     */
    public function setConnect($connect)
    {
        $this->connect = $connect;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @param mixed $stream
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }



}