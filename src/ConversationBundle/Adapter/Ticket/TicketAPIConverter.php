<?php

namespace ConversationBundle\Adapter\Ticket;

use ConversationBundle\Business\Manager\TicketManager;
use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TicketAPIConverter
 * @package UserBundle\Adapter\Group
 */
class TicketAPIConverter extends JsonAPIConverter
{
    /**
     * @param TicketManager $manager
     * @param Request       $request
     * @param string        $param
     */
    public function __construct(TicketManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, parent::convert());
    }

}