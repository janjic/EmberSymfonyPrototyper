<?php

namespace MailCampaignBundle\Business\Manager\MailList;
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
 * Class JsonApiSaveMailListManagerTrait
 * @package MailCampaignBundle\Business\Manager\MailList
 */
trait JsonApiSaveMailListManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function saveResource($data)
    {
        $data = $this->save(json_decode($data)->data->attributes);
        return $this->createJsonAPiSaveResponse($data);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        $data = json_decode(json_encode($data));
        switch (get_class($data)) {
            case Exception::class:
                return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
            case (\stdClass::class && $id = $data->id):
                return new ArrayCollection(AgentApiResponse::MAIL_LIST_SAVED_SUCCESSFULLY($id));
            default:
                return false;
        }
    }

}