<?php

namespace ConversationBundle\Adapter\Thread;

use ConversationBundle\Business\Manager\ThreadManager;
use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ThreadAPIConverter
 * @package ConversationBundle\Adapter\Thread
 */
class ThreadAPIConverter extends JsonAPIConverter
{
    /**
     * @param ThreadManager $manager
     * @param Request       $request
     * @param string        $param
     */
    public function __construct(ThreadManager $manager, Request $request, $param)
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