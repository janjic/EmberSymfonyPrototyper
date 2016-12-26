<?php

namespace MailCampaignBundle\Business\Manager\MailCampaign;
use ConversationBundle\Entity\Ticket;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiUpdateTicketManagerTrait
 * @package MailCampaignBundle\Business\Manager\Ticket
 */
trait JsonApiUpdateMailCampaignManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function updateResource($data)
    {
        $data = json_decode($data)->data;
        $campaign = $this->save($data);

        return $this->createResponse($campaign);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createResponse($data)
    {
        if(is_array($data) && $id = $data['id']){
            return new ArrayCollection(AgentApiResponse::MAIL_CAMPAIGN_SAVED_SUCCESSFULLY($id));
        } else {
            return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
        }
    }



}