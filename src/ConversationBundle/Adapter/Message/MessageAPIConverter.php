<?php

namespace ConversationBundle\Adapter\Message;

use ConversationBundle\Business\Manager\MessageManager;
use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MessageAPIConverter
 * @package ConversationBundle\Adapter\Message
 */
class MessageAPIConverter extends JsonAPIConverter
{
    /**
     * @param MessageManager $manager
     * @param Request        $request
     * @param string         $param
     */
    public function __construct(MessageManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, new ArrayCollection(parent::convert()));
    }
}