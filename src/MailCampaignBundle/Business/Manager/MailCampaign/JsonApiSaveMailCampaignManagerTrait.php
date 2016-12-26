<?php

namespace MailCampaignBundle\Business\Manager\MailCampaign;
use ConversationBundle\Entity\Ticket;
use ConversationBundle\Entity\TicketStatuses;
use ConversationBundle\Entity\TicketTypes;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use FOS\MessageBundle\MessageBuilder\NewThreadMessageBuilder;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\File;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiSaveMailCampaignManagerTrait
 * @package MailCampaignBundle\Business\Manager\Ticket
 */
trait JsonApiSaveMailCampaignManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function saveResource($data)
    {
        $data = json_decode($data)->data;
        $campaign = $this->save($data);
        return $this->createJsonAPiSaveResponse($campaign);
    }

    /**
     * @param $data
     * @return ArrayCollection
     */
    private function createJsonAPiSaveResponse($data)
    {
        if((is_array($data) && $id = $data['id'])){
            return new ArrayCollection(AgentApiResponse::MAIL_CAMPAIGN_SAVED_SUCCESSFULLY(($id)));
        } else {
            return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
        }
    }

}