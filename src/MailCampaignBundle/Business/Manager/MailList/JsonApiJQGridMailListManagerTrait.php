<?php

namespace MailCampaignBundle\Business\Manager\MailList;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiJQGridMailListManagerTrait
 * @package MailCampaignBundle\Business\Manager\MailList
 */
trait JsonApiJQGridMailListManagerTrait
{
    /**
     * @param $request
     * @return ArrayCollection
     */
    public function jqgridAction($request)
    {
        $params = null;
        $searchParams = null;
        $page = $request->get('page');
        $offset = $request->get('offset');

        $searchFields = array(
            'id'        => 'ticket.id',
            'title'     => 'ticket.title',
            'type'      => 'ticket.type',
            'status'    => 'ticket.status',
            'createdAt' => 'ticket.createdAt',
            'author'    => 'createdBy.username',
        );

        $sortParams = array($searchFields[$request->get('sidx')], $request->get('sord'));
        $params['page'] = $page;
        $params['offset'] = $offset;

        $additionalParams['ticketsType'] = $request->get('additionalData')['ticketsType'];
        $additionalParams['agentId'] = $request->get('additionalData')['agentId'];

        $agents = $this->findAllForJQGRID($page, $offset);
        $size = (int)$this->findAllForJQGRID($searchParams, $sortParams, true);
        $pageCount = ceil($size / $offset);

        return $agents;
        return new ArrayCollection($this->serializeTicket($agents)
            ->addMeta('totalItems', $size)
            ->addMeta('pages', $pageCount)
            ->addMeta('page', $page)
            ->toArray());
    }
}