<?php

namespace MailCampaignBundle\Adapter\MailList;

use ConversationBundle\Business\Manager\MessageManager;
use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use MailCampaignBundle\Adapter\MailCampaign\MailCampaignAdapterUtil;
use MailCampaignBundle\Business\Manager\MailCampaign\MailCampaignManager;
use MailCampaignBundle\Business\Manager\MailList\MailListManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MailListAdapter
 * @package MailCampaignBundle\Adapter\MailList
 */
class MailListAdapter extends BaseAdapter
{
    /**
     * @var MailListManager
     */
    protected $manager;

    /**
     * MailCampaignAdapter constructor.
     * @param MailListManager $manager
     */
    public function __construct(MailListManager $manager)
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