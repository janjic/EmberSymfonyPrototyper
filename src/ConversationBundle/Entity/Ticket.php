<?php

namespace ConversationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Model\ThreadInterface;
use UserBundle\Entity\Agent;

/**
 * @ORM\Entity
 * @ORM\Table(name="as_ticket")
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length = 30, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    protected $text;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length = 30, nullable=true)
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length = 30, nullable=true)
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Document\File", cascade={"all"}, orphanRemoval=TRUE)
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    protected $file;

    /**
     * @ORM\OneToOne(targetEntity="Thread", inversedBy="messages")
     * @var ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @var Agent
     */
    protected $forwardedTo;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Agent")
     * @var Agent
     */
    protected $createdBy;



}