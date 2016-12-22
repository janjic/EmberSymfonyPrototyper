<?php

namespace MailCampaignBundle\Business\Manager\MailList;

use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Exception;
use FSerializerBundle\services\FJsonApiSerializer;
use MailCampaignBundle\Business\Manager\MailList\JsonApiDeleteMailListManagerTrait;
use MailCampaignBundle\Business\Manager\MailList\JsonApiGetMailListManagerTrait;
use MailCampaignBundle\Business\Manager\MailList\JsonApiSaveMailListManagerTrait;
use MailCampaignBundle\Business\Manager\MailList\JsonApiUpdateMailListManagerTrait;
use MailCampaignBundle\Entity\MailCampaign;
use MailCampaignBundle\Entity\MailList;
use MailCampaignBundle\Util\MailCampaignSerializerInfo;
use MailCampaignBundle\Util\MailChimp;
use MailCampaignBundle\Util\MailListSerializerInfo;
use stdClass;


/**
 * Class MailListManager
 * @package MailCampaignBundle\Business\Manager\MailList
 */
class MailListManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiSaveMailListManagerTrait;
    use JsonApiDeleteMailListManagerTrait;
    use JsonApiGetMailListManagerTrait;
    use JsonApiUpdateMailListManagerTrait;


    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @var MailChimp $mailChimp
     */
    protected $mailChimp;

    /**
     * MailListManager constructor.
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(FJsonApiSerializer $fSerializer)
    {
        $this->fSerializer   = $fSerializer;
        $this->mailChimp     = new Mailchimp('f4e6c760118b21ed3ee0e8b26e693964-us14');
    }


    /**
     * @param $mailCampaign
     * @return array|Exception|false
     */
    public function save($mailCampaign)
    {
        $response = $this->mailChimp->post('lists', [
            'name' => $mailCampaign->name,
            'permission_reminder' => $mailCampaign->permission_reminder,
            'email_type_option' => false,
            'contact' => [
                'company' => 'Doe Ltd.',
                'address1' => 'DoeStreet 1',
                'address2' => '',
                'city' => 'Doesy',
                'state' => 'Doedoe',
                'zip' => '1672-12',
                'country' => 'US',
                'phone' => '55533344412'
            ],
            'campaign_defaults' => [
                'from_name' => $mailCampaign->fromName,
                'from_email' => $mailCampaign->fromAddress,
                'subject' => $mailCampaign->name,
                'language' => 'US'
            ]
        ]);
        if($this->mailChimp->success()){
            $id = $response['id'];

            if(count($mailCampaign->subscribers)){
                $members =  array();

                foreach ($mailCampaign->subscribers as $sub){
                    $member = array();
                    $member['status'] = 'subscribed';
                    $member['email_address'] = $sub->email;
                    $members[] = $member;
                }

                $subscribers = $this->mailChimp->post('lists/'.$id, [
                    'members' => $members
                ]);

                if(!$this->mailChimp->success()){
                    return new Exception($this->mailChimp->getLastError());
                }
            }

        } else {

            return new Exception($this->mailChimp->getLastError());
        }

        return $response;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getMailCampaignById($id)
    {

//        return $this->repository->findTicketById($id);
    }


    /**
     * @param $campaigns
     * @return \FSerializerBundle\Serializer\JsonApiDocument
     */
    public function serializeMailList($campaigns)
    {
        return $this->fSerializer->setType('mailLists')->setDeserializationClass(MailList::class)->serialize($campaigns, MailListSerializerInfo::$mappings, MailListSerializerInfo::$relations);

    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeMailList($content, $mappings = null)
    {
        return $this->fSerializer->setDeserializationClass(MailList::class)->deserialize($content, MailListSerializerInfo::$mappings, MailListSerializerInfo::$relations);
    }

//    public function getAgentById($id)
//    {
//        return $this->agentManager->findAgentById($id);
//    }
//
    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}