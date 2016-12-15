<?php

namespace UserBundle\Entity\Settings;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Settings
 * @package UserBundle\Entity\Settings
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\SettingsRepository")
 * @ORM\Table(name="as_settings")
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Document\Image", cascade={"all"}, orphanRemoval=TRUE)
     * @ORM\JoinColumn(name="avatar_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $image;

    /**
     * @var string
     * @ORM\Column(name="language", type="string", length=30, nullable=true)
     */
    protected $language;

    /**
     * @var string
     * @ORM\Column(name="confirmation_mail", type="string", length=40, nullable=true)
     */
    protected $confirmationMail;

    /**
     * @var string
     * @ORM\Column(name="pay_pal", type="string", length=40, nullable=true)
     */
    protected $payPal;

    /**
     * @var string
     * @ORM\Column(name="facebook_link", type="string", length=40, nullable=true)
     */
    protected $facebookLink;

    /**
     * @var string
     * @ORM\Column(name="easycall", type="string", length=40, nullable=true)
     */
    protected $easycall;

    /**
     * @var string
     * @ORM\Column(name="twitter_link", type="string", length=40, nullable=true)
     */
    protected $twitterLink;

    /**
     * @var string
     * @ORM\Column(name="g_plus_link", type="string", length=40, nullable=true)
     */
    protected $gPlusLink;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Settings\Commission", cascade={"all"}, mappedBy="settings")
     */
    protected $commissions;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Settings\Bonus", cascade={"all"}, mappedBy="settings")
     */
    protected $bonuses;

    /**
     * Settings constructor.
     */
    public function __construct()
    {
        $this->commissions  = new ArrayCollection();
        $this->bonuses      = new ArrayCollection();
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
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmationMail()
    {
        return $this->confirmationMail;
    }

    /**
     * @param string $confirmationMail
     * @return $this
     */
    public function setConfirmationMail($confirmationMail)
    {
        $this->confirmationMail = $confirmationMail;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayPal()
    {
        return $this->payPal;
    }

    /**
     * @param string $payPal
     * @return $this
     */
    public function setPayPal($payPal)
    {
        $this->payPal = $payPal;

        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    /**
     * @param string $facebookLink
     * @return $this
     */
    public function setFacebookLink($facebookLink)
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    /**
     * @return string
     */
    public function getEasycall()
    {
        return $this->easycall;
    }

    /**
     * @param string $easycall
     * @return $this
     */
    public function setEasycall($easycall)
    {
        $this->easycall = $easycall;

        return $this;
    }

    /**
     * @return string
     */
    public function getTwitterLink()
    {
        return $this->twitterLink;
    }

    /**
     * @param string $twitterLink
     * @return $this
     */
    public function setTwitterLink($twitterLink)
    {
        $this->twitterLink = $twitterLink;

        return $this;
    }

    /**
     * @return string
     */
    public function getGPlusLink()
    {
        return $this->gPlusLink;
    }

    /**
     * @param string $gPlusLink
     * @return $this
     */
    public function setGPlusLink($gPlusLink)
    {
        $this->gPlusLink = $gPlusLink;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommissions()
    {
        return $this->commissions;
    }

    /**
     * @param Commission $commission
     */
    public function addCommision(Commission $commission)
    {
        $this->commissions->add($commission);
    }

    /**
     * @param Commission $commission
     */
    public function removeCommission(Commission $commission)
    {
        $this->commissions->removeElement($commission);
    }

    /**
     * @return mixed
     */
    public function getBonuses()
    {
        return $this->bonuses;
    }

    /**
     * @param Bonus $bonus
     */
    public function addBonus(Bonus $bonus)
    {
        $this->commissions->add($bonus);
    }

    /**
     * @param Bonus $bonus
     */
    public function removeBonus(Bonus $bonus)
    {
        $this->commissions->removeElement($bonus);
    }

}