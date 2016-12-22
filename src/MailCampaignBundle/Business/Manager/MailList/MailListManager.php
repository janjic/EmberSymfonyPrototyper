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


    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

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
     * @param FJsonApiSerializer $fSerializer
     * @param TokenStorage $tokenStorage
     */
    public function __construct(FJsonApiSerializer $fSerializer, TokenStorage $tokenStorage)
    {
        $this->fSerializer   = $fSerializer;
        $this->tokenStorage  = $tokenStorage;
        $this->mailChimp     = new Mailchimp('f4e6c760118b21ed3ee0e8b26e693964-us14');
    }


    /**
     * @param $mailCampaign
     * @return array|Exception|false
     */
    public function save($mailCampaign)
    {
        $currentUser = $this->getCurrentUser();
        /**
         * @var Address $address
         */
        $address = $currentUser->getAddress();
        $response = $this->mailChimp->post('lists', [
            'name' => $mailCampaign->name,
            'permission_reminder' => $mailCampaign->permission_reminder,
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
     * @param $mailLists
     * @return \FSerializerBundle\Serializer\JsonApiDocument
     */
    public function serializeMailList($mailLists)
    {
        return $this->fSerializer->setType('mailLists')->setDeserializationClass(MailList::class)->serialize($mailLists, MailListSerializerInfo::$mappings, MailListSerializerInfo::$relations);

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

    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}