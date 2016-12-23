<?php

namespace MailCampaignBundle\Adapter\MailList;

use ConversationBundle\Business\Manager\MessageManager;
use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use MailCampaignBundle\Business\Manager\MailCampaignManager;
use MailCampaignBundle\Business\Manager\MailList\MailListManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MailListAPIConverter
 * @package MailCampaignBundle\Adapter\MailList
 */
class MailListAPIConverter extends JsonAPIConverter
{
    /**
     * @param MailListManager $manager
     * @param Request             $request
     * @param string              $param
     */
    public function __construct(MailListManager $manager, Request $request, $param)
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