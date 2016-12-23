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


    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @var MailChimp $mailChimp
     */
    protected $mailChimp;

    /**
     * MailCampaignManager constructor.
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(FJsonApiSerializer $fSerializer)
    {
        $this->fSerializer     = $fSerializer;
        $this->mailChimp     = new Mailchimp('f4e6c760118b21ed3ee0e8b26e693964-us14');
    }


    /**
     * @param $mailCampaign
     * @return mixed
     */
    public function save($mailCampaign)
    {
        $campaign = $this->mailChimp->post('campaigns', [
            'recipients' => [
                'list_id'=> $mailCampaign->relationships->mailList->data->id
            ],
            'type' => 'regular',
            'settings' => [
                'subject_line' => $mailCampaign->attributes->subject_line,
                'reply_to'    => $mailCampaign->attributes->reply_to,
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
                   return $mailCampaign;
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
     * @param $campaigns
     * @return \FSerializerBundle\Serializer\JsonApiDocument
     */
    public function serializeMailCampaign($campaigns)
    {
        return $this->fSerializer->setType('campaigns')->setDeserializationClass(MailCampaign::class)->serialize($campaigns, MailCampaignSerializerInfo::$mappings, MailCampaignSerializerInfo::$relations);

    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeMailCampaign($content, $mappings = null)
    {
        return $this->fSerializer->setDeserializationClass(MailCampaign::class)->deserialize($content, MailCampaignSerializerInfo::$mappings, MailCampaignSerializerInfo::$relations);
    }

    /**
     * @return array|false
     */
    public function getCampaignTemplates()
    {
        $templates = $this->mailChimp->get('/templates');

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
}