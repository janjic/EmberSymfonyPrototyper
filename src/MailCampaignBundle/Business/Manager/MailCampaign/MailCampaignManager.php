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
     * MailCampaignManager constructor.
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(FJsonApiSerializer $fSerializer)
    {
        $this->fSerializer     = $fSerializer;
    }


    /**
     * @param MailCampaign $mailCampaign
     * @return Exception|MailCampaign
     * @internal param MailCampaign $ticket
     */
    public function save(MailCampaign $mailCampaign)
    {
//        $ticket = $this->repository->saveTicket($ticket);

        if ($mailCampaign instanceof Exception) {
            return $mailCampaign;
        }

        return $mailCampaign;
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

//    public function getAgentById($id)
//    {
//        return $this->agentManager->findAgentById($id);
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getCurrentUser()
//    {
//        return $this->tokenStorage->getToken()->getUser();
//    }
}