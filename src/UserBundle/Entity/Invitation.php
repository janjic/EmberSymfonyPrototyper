<?php

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
     * @var array
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
     * @ORM\Column(name="mail_list_id", type="text")
     */
    private $mailList;

    /**
     * @var string
     * @ORM\Column(name="email_content", type="text")
     */
    private $emailContent;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @@ORM\JoinColumn(name="agent_id", referencedColumnName="id", onDelete="SET NULL")
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array
     */
    public function getRecipientEmail()
    {
        return $this->recipientEmail;
    }

    /**
     * @param array $recipientEmail
     * @return $this
     */
    public function setRecipientEmail($recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;

        return $this;
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
     * @return $this
     */
    public function setEmailSubject($emailSubject)
    {
        $this->emailSubject = $emailSubject;

        return $this;
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
     * @return $this
     */
    public function setEmailContent($emailContent)
    {
        $this->emailContent = $emailContent;

        return $this;
    }

    /**
     * @return string
     */
    public function getMailList()
    {
        return $this->mailList;
    }

    /**
     * @param string $mailList
     */
    public function setMailList($mailList)
    {
        $this->mailList = $mailList;
    }

}