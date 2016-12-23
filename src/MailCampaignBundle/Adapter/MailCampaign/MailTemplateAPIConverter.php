<?php

namespace MailCampaignBundle\Adapter\MailCampaign;

use ConversationBundle\Business\Manager\MessageManager;
use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use MailCampaignBundle\Business\Manager\MailCampaign\MailCampaignManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MailTemplateAPIConverter
 * @package MailCampaignBundle\Adapter\MailCampaign
 */
class MailTemplateAPIConverter extends BasicConverter
{
    /**
     * @param MailCampaignManager $manager
     * @param Request             $request
     * @param string              $param
     */
    public function __construct(MailCampaignManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $templates = $this->manager->getCampaignTemplates();

        $this->request->attributes->set($this->param, new ArrayCollection($templates));
    }
}