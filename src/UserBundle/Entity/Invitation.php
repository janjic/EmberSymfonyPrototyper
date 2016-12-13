<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 13.12.16.
 * Time: 11.40
 */

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Role
 * @package UserBundle\Entity
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\InvitationRepository")
 * @ORM\Table(name="as_invitation")
 */
class Invitation
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(name="recipient_email", type="simple_array", length=100)
     */
    private $recipientEmail;
    /**
     * @var string
     * @ORM\Column(name="email_subject", type="string", length=30)
     */
    private $emailSubject;
    /**
     * @var string
     * @ORM\Column(name="email_content", type="text")
     */
    private $emailContent;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @@ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     */
    protected $agent;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRecipientEmail()
    {
        return $this->recipientEmail;
    }

    /**
     * @param string $recipientEmail
     */
    public function setRecipientEmail($recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;
    }

    /**
     * @return string
     */
    public function getEmailSubject()
    {
        return $this->emailSubject;
    }

    /**
     * @param string $emailSubject
     */
    public function setEmailSubject($emailSubject)
    {
        $this->emailSubject = $emailSubject;
    }

    /**
     * @return string
     */
    public function getEmailContent()
    {
        return $this->emailContent;
    }

    /**
     * @param string $emailContent
     */
    public function setEmailContent($emailContent)
    {
        $this->emailContent = $emailContent;
    }
}