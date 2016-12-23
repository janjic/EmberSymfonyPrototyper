<?php

namespace MailCampaignBundle\Business\Manager\MailList;

use ConversationBundle\Entity\Ticket;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\Agent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class JsonApiGetMailListManagerTrait
 * @package MailCampaignBundle\Business\Manager\MailList
 */
trait JsonApiGetMailListManagerTrait
{
    /**
     * {@inheritdoc}
     */
    public function getResource($id = null)
    {
        $list = $this->mailChimp->get('lists/'.$id);
        $list['fromAddress'] = $list['campaign_defaults']['from_email'];
        $list['fromName'] = $list['campaign_defaults']['from_name'];

        $members = $this->mailChimp->get('/lists/'.$id.'/members');
        $subscribers = [];

        /**
         * ------ Subscribers as objects serialization
         */

//        $subscribersIncluded = [];
//        $relationships = [];
//        if(count($members['members'])){
//            foreach ($members['members'] as $member){
//                $subscribers[] = array('type'=>'subscribers', 'id' => $member['id']);
//                $subscribersIncluded[] = array('attributes'=> array('email'=>$member['email_address']), 'id' => $member['id'], 'type'=> 'subscribers');
//            }
//            $relationships['subscribers']['data'] = $subscribers;
//        }
//
//        return new ArrayCollection(array('data' => array('attributes' =>$list, 'id' => $id, 'type' => 'mail-lists', 'relationships' => $relationships), 'included' => $subscribersIncluded));

        /**
         * ------ End subscribers as objects serialization
         */

        if(count($members['members'])){
            foreach ($members['members'] as $member){
                if($member['status'] == 'subscribed'){
                    $subscribers[] = $member['email_address'];
                }
            }
        }
        $list['subscribers'] = $subscribers;

        return new ArrayCollection(array('data' => array('attributes' =>$list, 'id' => $id, 'type' => 'mail-lists')));


    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonApiGetResponse($data)
    {
        if (!is_null($data) && get_class($data) == Ticket::class)  {
            return new ArrayCollection($this->serializeMailList($data)->toArray());
        } else if(!is_null($data) && get_class($data) == AccessDeniedException::class) {
            return new ArrayCollection(AgentApiResponse::ACCESS_TO_TICKET_DENIED);
        }

        return new ArrayCollection(AgentApiResponse::AGENT_NOT_FOUND_RESPONSE);
    }

}