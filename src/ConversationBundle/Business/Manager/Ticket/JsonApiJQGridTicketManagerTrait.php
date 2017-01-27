<?php

namespace ConversationBundle\Business\Manager\Ticket;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiJQGridTicketManagerTrait
 * @package ConversationBundle\Business\Manager\Ticket
 */
trait JsonApiJQGridTicketManagerTrait
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
            'id'          => 'ticket.id',
            'title'       => 'ticket.title',
            'type'        => 'ticket.type',
            'status'      => 'ticket.status',
            'createdAt'   => 'ticket.createdAt',
            'createdBy'   => 'createdBy.username',
            'forwardedTo' => 'forwardedTo.username',
        );

        $sortParams = array($searchFields[$request->get('sidx')], $request->get('sord'));
        $params['page'] = $page;
        $params['offset'] = $offset;

        $additionalParams['ticketsType'] = $request->get('additionalData')['ticketsType'];
        $additionalParams['agentId'] = $request->get('additionalData')['agentId'];

        if ($filters = $request->get('filters')) {
            $searchParams = array(array('toolbar_search' => true, 'rows' => $offset, 'page' => $page), array());
            foreach ($rules = json_decode($filters)->rules as $rule) {
                $searchParams[1][$searchFields[$rule->field]] = $rule->data;
            }
            $agents = $this->repository->searchForJQGRID($searchParams, $sortParams, $additionalParams);
        } else {
            $agents = $this->repository->findAllForJQGRID($page, $offset, $sortParams, $additionalParams);
        }

        $size = (int)$this->repository->searchForJQGRID($searchParams, $sortParams, $additionalParams, true)[0][1];
        $pageCount = ceil($size / $offset);

        return new ArrayCollection($this->serializeTicket($agents)
            ->addMeta('totalItems', $size)
            ->addMeta('pages', $pageCount)
            ->addMeta('page', $page)
            ->toArray());
    }
}