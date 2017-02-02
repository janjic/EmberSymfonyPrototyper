<?php

namespace MailCampaignBundle\Business\Manager\MailCampaign;

use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Exception;
use FSerializerBundle\services\FJsonApiSerializer;
use MailCampaignBundle\Business\Manager\MailCampaign\JsonApiDeleteMailCampaignManagerTrait;
use MailCampaignBundle\Business\Manager\MailCampaign\JsonApiGetMailCampaignManagerTrait;
use MailCampaignBundle\Business\Manager\MailCampaign\JsonApiSaveMailCampaignManagerTrait;
use MailCampaignBundle\Business\Manager\MailCampaign\JsonApiUpdateMailCampaignManagerTrait;
use MailCampaignBundle\Entity\MailCampaign;
use MailCampaignBundle\Util\MailCampaignSerializerInfo;
use MailCampaignBundle\Util\MailChimp;
use UserBundle\Business\Manager\SettingsManager;
use UserBundle\Entity\Settings\Settings;


/**
 * Class MailCampaignManager
 * @package MailCampaignBundle\Business\Manager\MailCampaign
 */
class MailCampaignManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiSaveMailCampaignManagerTrait;
    use JsonApiDeleteMailCampaignManagerTrait;
    use JsonApiGetMailCampaignManagerTrait;
    use JsonApiUpdateMailCampaignManagerTrait;
    use JsonApiJQGridMailCampaignManagerTrait;

    const MAIL_CHIMP_API = 'f4e6c760118b21ed3ee0e8b26e693964-us14';

    /**
     * @var MailChimp $mailChimp
     */
    protected $mailChimp;

    /**
     * @var $settingsManager SettingsManager
     */
    protected $settingsManager;

    /**
     * MailCampaignManager constructor.
     * @param SettingsManager $settingsManager
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->mailChimp = new Mailchimp(self::MAIL_CHIMP_API);
        $this->settingsManager = $settingsManager;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settingsManager->getEntity();
    }

    /**
     * @param $mailCampaign
     * @return mixed
     */
    public function save($mailCampaign)
    {
        /**
         * @var $settings Settings
         */
        $settings = $this->getSettings();

        $campaign = $this->mailChimp->post('campaigns', [
            'recipients' => [
                'list_id'=> $mailCampaign->relationships->mailList->data->id
            ],
            'type' => 'regular',
            'settings' => [
                'subject_line' => $mailCampaign->attributes->subject_line,
//                'reply_to'    => $mailCampaign->attributes->reply_to,
                'reply_to'    => $settings->getConfirmationMail(),
                'from_name'    => $mailCampaign->attributes->from_name
            ]
        ]);

        if($this->mailChimp->success()){
            $this->mailChimp->put('campaigns/'.$campaign['id'].'/content',[
                'template' => [
                    'id' => intval($mailCampaign->relationships->template->data->id)
                ]
            ]);
            if($this->mailChimp->success()) {
                $this->mailChimp->post('campaigns/'.$campaign['id'].'/actions/send');
                if($this->mailChimp->success()) {

                    return $campaign;
                } else {
                    return new Exception($this->mailChimp->getLastError());
                }
            }
            else {
                $exception = new Exception($this->mailChimp->getLastError());

                $this->mailChimp->delete('campaigns/'.$campaign['id']);

                return $exception;
            }
        }
        else {
            return new Exception($this->mailChimp->getLastError());
        }
    }

    /**
     * @return array|false
     */
    public function getCampaignTemplates()
    {
        $templatesCount = $this->mailChimp->get('/templates', ['fields' => 'total_items']);

        $templates = $this->mailChimp->get('/templates', [
            'count' => $templatesCount['total_items']
        ]);

        $templatesArray = [];
        foreach ($templates['templates'] as $template){
            if($template['type'] == 'user'){
                $item = [];
                $item['id'] = $template['id'];
                $item['name'] = $template['name'];
                $templatesArray[] = array('attributes' =>$item, 'id' => $item['id'], 'type' => 'mail-template');
            }
        }

        return  array('data'=>$templatesArray);
    }

    /**
     * @param $page
     * @param $offset
     * @param bool $isCount
     * @return array|false|int
     */
    public function findAllForJQGRID($page, $offset, $isCount = false)
    {
        if($isCount){
            $campaigns = $this->mailChimp->get('campaigns');

            return intval($campaigns['total_items']);
        } else {
            $firstResult = 0;
            if (intval($page) !=1 ) {
                $firstResult = ($page-1)*$offset;
            }

            $campaigns = $this->mailChimp->get('campaigns',[
                'fields' => 'campaigns.id,campaigns.status,campaigns.recipients.list_name,campaigns.recipients.recipient_count,'.
                    'campaigns.settings.subject_line,campaigns.settings.from_name,campaigns.settings.reply_to,campaigns.report_summary.unique_opens,',
                'offset' => $firstResult,
                'count' => $offset
            ]);
            $lists = $this->serializeCampaignsArray($campaigns['campaigns']);

            return $lists;
        }

    }

    /**
     * @param $campaigns
     * @return array
     */
    public function serializeCampaignsArray($campaigns)
    {
        if ( is_array($campaigns) ) {
            if (!array_key_exists('id', $campaigns)) {
                $array = [];
                foreach ($campaigns as $campaign) {

                    $item = [];
                    $item['id'] = $campaign['id'];
                    $item['subject_line'] = $campaign['settings']['subject_line'];
                    $item['reply_to'] = $campaign['settings']['reply_to'];
                    $item['from_name'] = $campaign['settings']['from_name'];

                    $array[] = array('attributes' => $item, 'id' => $campaign['id'], 'type' => 'mail-campaigns');
                }

                return $array;

            } else {
                $item = [];
                $item['id'] = $campaigns['id'];
                $item['subject_line'] = $campaigns['settings']['subject_line'];
                $item['reply_to'] = $campaigns['settings']['reply_to'];
                $item['from_name'] = $campaigns['settings']['from_name'];

                return $item;
            }
        }

        return [];
    }
}