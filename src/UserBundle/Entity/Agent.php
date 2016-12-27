<?php

namespace UserBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Tree;
use Gedmo\Mapping\Annotation\TreeLeft;
use Gedmo\Mapping\Annotation\TreeLevel;
use Gedmo\Mapping\Annotation\TreeParent;
use Gedmo\Mapping\Annotation\TreeRight;
use Gedmo\Mapping\Annotation\TreeRoot;

/**
 * Class Agent
 * @package UserBundle\Entity
 * @Tree(type="nested")
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\AgentRepository")
 * @ORM\Table(name="as_agent")
 */
class Agent extends BaseUser implements ParticipantInterface
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
     * @ORM\Column(name="title", type="string", length=30, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="agent_code", type="string", length=30, nullable=true)
     */
    protected $agentId;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=30, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=30, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(name="private_email", type="string", length=30, nullable=true)
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
     * @ORM\Column(name="bank_name", type="string", length=30, nullable=true)
     */
    protected $bankName;

    /**
     * @var string
     * @ORM\Column(name="bank_account_number", type="string", length=30, nullable=true)
     */
    protected $bankAccountNumber;

    /**
     * @var string
     * @ORM\Column(name="agent_bacground", type="string", length=30, nullable=true)
     */
    protected $agentBackground;

    /**
     * @TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @TreeParent
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent", inversedBy="children")
     * @ORM\JoinColumn(name="superior_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $superior;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Agent", mappedBy="superior")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Document\Image", cascade={"all"}, orphanRemoval=TRUE)
     * @ORM\JoinColumn(name="avatar_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    protected $image;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Address", cascade={"all"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
     **/
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Group")
     * @@ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;


    public function __construct()
    {
        parent::__construct();
        $this->children = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), parent::getRoles(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
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
        if (!($birthDate instanceof DateTime)) {
            $birthDate =  new DateTime($birthDate);
        }
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
     * @return Address|null
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
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getSuperior()
    {
        return $this->superior;
    }

    /**
     * @param mixed $superior
     */
    public function setSuperior($superior)
    {
        $this->superior = $superior;
    }

    /**
     * @return mixed
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @param mixed $lft
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    /**
     * @return mixed
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * @param mixed $lvl
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * @return mixed
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @param mixed $rgt
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    }

    /**
     * @return mixed
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param mixed $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @param Agent $child
     */
    public function addChild($child)
    {
        $this->children->add($child);
        $child->setSuperior($this);
    }

    /**
     * @param Agent $child
     */
    public function removeChild($child)
    {
        $this->children->removeElement($child);
        $child->setSuperior(null);
    }


    /**
     * @param string $property
     *
     * @return mixed
     */
    public function getPropertyValue ($property)
    {
        if ($this->{$property}) {
            return $this->{$property};
        }

        return null;
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @return $this
     */
    public function setPropertyValue($name, $value)
    {
        $this->{$name} = $value;

        return $this;
    }

}