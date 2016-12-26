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
        if($id == 'all'){
            /**
             * Get number of lists
             */
            $listCount = $this->mailChimp->get('lists', [
                'fields' => 'total_items'
            ]);

            $lists = $this->mailChimp->get('lists', [
                'count' => $listCount
            ]);
            $array = [];

            foreach ($lists['lists'] as $list){
                $item = [];
                $item['fromAddress'] = $list['campaign_defaults']['from_email'];
                $item['fromName'] = $list['campaign_defaults']['from_name'];
                $item['name'] = $list['name'];
                $item['permission_reminder'] = $list['permission_reminder'];
                $array[] = array('attributes' =>$item, 'id' => $list['id'], 'type' => 'mail-lists');
            }

            return new ArrayCollection(array('data'=>$array));
        }

        $list = $this->mailChimp->get('lists/'.$id);
        $list['fromAddress'] = $list['campaign_defaults']['from_email'];
        $list['fromName'] = $list['campaign_defaults']['from_name'];

        $members = $this->mailChimp->get('/lists/'.$id.'/members');
        $subscribers = [];

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


}