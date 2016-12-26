<?php

namespace MailCampaignBundle\Adapter\MailList;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class MailListAdapterUtil
 * @package MailCampaignBundle\Adapter\MailList
 */
abstract class MailListAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';
    const MAIL_LIST_API = 'mailListAPI';
}