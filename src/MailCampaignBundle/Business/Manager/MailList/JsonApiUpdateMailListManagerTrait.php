<?php

namespace MailCampaignBundle\Business\Manager\MailList;
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
 * Class JsonApiUpdateMailListManagerTrait
 * @package MailCampaignBundle\Business\Manager\MailList
 */
trait JsonApiUpdateMailListManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function updateResource($data)
    {
        $data = $this->edit($data);

        return $this->createResponse($data);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createResponse($data)
    {
        if(is_array($data) && $id = $data['id']){
            return new ArrayCollection(AgentApiResponse::MAIL_LIST_SAVED_SUCCESSFULLY($id));
        } else {
            return new ArrayCollection(AgentApiResponse::ERROR_RESPONSE($data));
        }
    }



}