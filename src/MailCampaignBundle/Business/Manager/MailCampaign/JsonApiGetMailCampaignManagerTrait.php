<?php

namespace MailCampaignBundle\Business\Manager\MailCampaign;

use ConversationBundle\Entity\Ticket;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\Agent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class JsonApiGetMailCampaignManagerTrait
 * @package MailCampaignBundle\Business\Manager\Ticket
 */
trait JsonApiGetMailCampaignManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function getResource($id = null)
    {
        $campaign = $this->mailChimp->get('campaigns/'.$id);
        $campaignSerialized = $this->serializeCampaignsArray($campaign);

        $relationships = [];
        $relationships['template'] = array('data' => array('id' => $campaign['settings']['template_id'], 'type' => 'mail-templates'));
        $relationships['mailList'] = array('data' => array('id' => $campaign['recipients']['list_id'], 'type' => 'mail-lists'));

        return new ArrayCollection(array('data' => array('attributes' =>$campaignSerialized, 'relationships'=> $relationships, 'id' => $id, 'type' => 'mail-campaigns')));

    }

}