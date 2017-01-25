<?php

namespace MailCampaignBundle\Business\Manager\MailList;

use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use UserBundle\Entity\Address;


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
    use JsonApiJQGridMailListManagerTrait;

    /**
     * @var MailChimp $mailChimp
     */
    protected $mailChimp;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * MailListManager constructor.
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage  = $tokenStorage;
        $this->mailChimp     = new Mailchimp('f4e6c760118b21ed3ee0e8b26e693964-us14');
    }


    /**
     * @param $mailList
     * @return array|Exception|false
     */
    public function save($mailList)
    {
        $currentUser = $this->getCurrentUser();
        /**
         * @var Address $address
         */
        $address = $currentUser->getAddress();
        $response = $this->mailChimp->post('lists', [
            'name' => $mailList->name,
            'permission_reminder' => $mailList->permission_reminder,
            'email_type_option' => false,
            'visibility'=> 'prv',
            'contact' => [
                'company' => '',
                'address1' => $address->getStreetNumber(),
                'address2' => '',
                'city' => $address->getCity(),
                'state' => $address->getCountry(),
                'zip' => $address->getPostcode(),
                'country' => $address->getCountry(),
                'phone' => $address->getPhone()
            ],
            'campaign_defaults' => [
                'from_name' => $mailList->fromName,
                'from_email' => $mailList->fromAddress,
                'subject' => $mailList->name,
                'language' => 'US'
            ]
        ]);
        if($this->mailChimp->success()){

            $id = $response['id'];

            if(count($mailList->subscribers)){
                $members =  array();

                foreach ($mailList->subscribers as $sub){
                    $member = array();
                    $member['status'] = 'subscribed';
                    $member['email_address'] = $sub->email;
                    $members[] = $member;
                }

                $subscribers = $this->mailChimp->post('lists/'.$id, [
                    'members' => $members
                ]);
                if(!$this->mailChimp->success()){
                    $message = '';
                    foreach ($response['errors'] as $error) {
                        $message = $message.'Field : '.$error['field'].', Message: '.$error['message'];
                    }
                    return new Exception($message);
                }
            }

        } else {
            var_dump($response);exit;
            $message = '';
            foreach ($response['errors'] as $error) {
                $message = $message.'Field : '.$error['field'].', Message: '.$error['message'];
            }
            return new Exception($message);
        }

        return $response;
    }

    /**
     * @param $mailList
     * @return array|Exception|false
     */
    public function edit($mailList){

        $mailList = json_decode($mailList)->data;

        $currentUser = $this->getCurrentUser();
        $id = $mailList->id;
        /**
         * @var Address $address
         */
        $address = $currentUser->getAddress();

        $response = $this->mailChimp->patch('lists/'.$id, [
            'name' => $mailList->attributes->name,
            'permission_reminder' => $mailList->attributes->permission_reminder,
            'email_type_option' => false,
            'contact' => [
                'company' => '',
                'address1' => $address->getStreetNumber(),
                'address2' => '',
                'city' => $address->getCity(),
                'state' => $address->getCountry(),
                'zip' => $address->getPostcode(),
                'country' => $address->getCountry(),
                'phone' => $address->getPhone()
            ],
            'campaign_defaults' => [
                'from_name' => $mailList->attributes->fromName,
                'from_email' => $mailList->attributes->fromAddress,
                'subject' => $mailList->attributes->name,
                'language' => 'US'
            ]
        ]);
//        var_dump($response);exit;
        if($this->mailChimp->success()){

            $id = $response['id'];

            if(count($mailList->attributes->removedSubscribers) || count($mailList->attributes->newSubscribers)){

                $members =  array();

                foreach ($mailList->attributes->removedSubscribers as $sub){
                    $member = array();
                    $member['status'] = 'unsubscribed';
                    $member['email_address'] = $sub->email;
                    $members[] = $member;
                }

                foreach ($mailList->attributes->newSubscribers as $sub){
                    $member = array();
                    $member['status'] = 'subscribed';
                    $member['email_address'] = $sub->email;
                    $members[] = $member;
                }
                $subscribers = $this->mailChimp->post('lists/'.$id, [
                    'members' => $members,
                    'update_existing' => true
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
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }


    public function findAllForJQGRID($page, $offset, $isCount = false)
    {
        if($isCount){
            $lists = $this->mailChimp->get('lists');

            return intval($lists['total_items']);
        } else {
            $firstResult = 0;
            if (intval($page) !=1 ) {
                $firstResult = ($page-1)*$offset;
            }

            $lists = $this->mailChimp->get('lists',[
                'fields' => 'lists.id,lists.name,lists.stats.member_count,lists.permission_reminder,lists.campaign_defaults.from_name,lists.campaign_defaults.from_email',
                'offset' => $firstResult,
                'count' => $offset
            ]);

            $lists = $this->serializeListsArray($lists['lists']);

            return $lists;
        }

    }

    /**
     * @param $lists
     * @return array
     */
    public function serializeListsArray($lists)
    {
        $array = [];
        if( is_array($lists)) {
            foreach ($lists as $list) {

                $item = [];
                $item['fromAddress'] = $list['campaign_defaults']['from_email'];
                $item['fromName'] = $list['campaign_defaults']['from_name'];
                $item['name'] = $list['name'];
                $item['permission_reminder'] = $list['permission_reminder'];
                $array[] = array('attributes' => $item, 'id' => $list['id'], 'type' => 'mail-lists');
            }
        }

        return $array;
    }
}