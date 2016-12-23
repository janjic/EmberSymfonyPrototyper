<?php

namespace MailCampaignBundle\Adapter\MailCampaign   ;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class MailCampaignAdapterUtil
 * @package MailCampaignBundle\Adapter\MailCampaign
 */
abstract class MailCampaignAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';
    const MAIL_CAMPAIGN_API   = 'mailCampaignAPI';
    const MAIL_TEMPLATES_API  = 'mailTemplateAPI';


}