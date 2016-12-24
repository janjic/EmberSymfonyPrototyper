<?php

namespace MailCampaignBundle\Adapter\MailCampaign;

use ConversationBundle\Business\Manager\MessageManager;
use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use MailCampaignBundle\Business\Manager\MailCampaign\MailCampaignManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MailCampaignAdapter
 * @package MailCampaignBundle\Adapter\MailCampaign
 */
class MailCampaignAdapter extends BaseAdapter
{
    /**
     * @var MailCampaignManager
     */
    protected $manager;

    /**
     * MailCampaignAdapter constructor.
     * @param MailCampaignManager $manager
     */
    public function __construct(MailCampaignManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).MailCampaignAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->manager, $request, $param);
    }
}