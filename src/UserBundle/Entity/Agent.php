<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Agent
 * @package UserBundle\Entity
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\AgentRepository")
 * @ORM\Table(name="as_agent")
 */
class Agent extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=30)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="agent_code", type="string", length=30)
     */
    protected $agentId;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=30)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=30)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(name="private_email", type="string", length=30)
     */
    protected $privateEmail;

    /**
     * @ORM\Column(name="base_image_url", type="text", nullable=true)
     */
    protected $baseImageUrl;

    /**
     * @ORM\Column(name="social_security_number", type="text", nullable=true)
     */
    protected $socialSecurityNumber;

    /**
     * @ORM\Column(name="nationality", type="text", nullable=true)
     */
    protected $nationality;

    /**
     * @var string
     * @ORM\Column(name="birth_date", type="date", length=255, nullable=true)
     */
    protected $birthDate;

    /**
     * @var string
     * @ORM\Column(name="bank_name", type="string", length=30)
     */
    protected $bankName;

    /**
     * @var string
     * @ORM\Column(name="bank_account_number", type="string", length=30)
     */
    protected $bankAccountNumber;

    /**
     * @var string
     * @ORM\Column(name="agent_bacground", type="string", length=30)
     */
    protected $agentBackground;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Document\Image", cascade={"all"}, orphanRemoval=TRUE)
     * @ORM\JoinColumn(name="avatar_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    protected $image;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Address", cascade={"all"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Role")
     * @@ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    protected $role;

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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAgentId()
    {
        return $this->agentId;
    }

    /**
     * @param string $agentId
     */
    public function setAgentId($agentId)
    {
        $this->agentId = $agentId;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPrivateEmail()
    {
        return $this->privateEmail;
    }

    /**
     * @param string $privateEmail
     */
    public function setPrivateEmail($privateEmail)
    {
        $this->privateEmail = $privateEmail;
    }

    /**
     * @return mixed
     */
    public function getBaseImageUrl()
    {
        return $this->baseImageUrl;
    }

    /**
     * @param mixed $baseImageUrl
     */
    public function setBaseImageUrl($baseImageUrl)
    {
        $this->baseImageUrl = $baseImageUrl;
    }

    /**
     * @return mixed
     */
    public function getSocialSecurityNumber()
    {
        return $this->socialSecurityNumber;
    }

    /**
     * @param mixed $socialSecurityNumber
     */
    public function setSocialSecurityNumber($socialSecurityNumber)
    {
        $this->socialSecurityNumber = $socialSecurityNumber;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @param string $bankName
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }

    /**
     * @return string
     */
    public function getBankAccountNumber()
    {
        return $this->bankAccountNumber;
    }

    /**
     * @param string $bankAccountNumber
     */
    public function setBankAccountNumber($bankAccountNumber)
    {
        $this->bankAccountNumber = $bankAccountNumber;
    }

    /**
     * @return string
     */
    public function getAgentBackground()
    {
        return $this->agentBackground;
    }

    /**
     * @param string $agentBackground
     */
    public function setAgentBackground($agentBackground)
    {
        $this->agentBackground = $agentBackground;
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
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

}