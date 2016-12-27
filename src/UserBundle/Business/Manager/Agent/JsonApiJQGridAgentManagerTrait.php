<?php

namespace UserBundle\Business\Manager\Agent;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiJQGridAgentManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiJQGridAgentManagerTrait
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
            'id'              => 'agent.id',
            'username'        => 'agent.username',
            'firstName'       => 'agent.firstName',
            'lastName'        => 'agent.lastName',
            'group.name'      => 'group.name',
            'enabled'         => 'agent.enabled',
            'address.country' => 'address.country'
        );

        $sortParams = array($searchFields[$request->get('sidx')], $request->get('sord'));
        $params['page'] = $page;
        $params['offset'] = $offset;
        $additionalParams = array('or'=>false);
        if ($filters = $request->get('filters')) {
            $searchParams = array(array('toolbar_search' => true, 'rows' => $offset, 'page' => $page), array());
            $filters = json_decode($filters);
            if ($filters->groupOp == 'or') {
                $additionalParams['or'] = true;
            }
            foreach ($rules = $filters->rules as $rule) {
                $searchParams[1][$searchFields[$rule->field]] = $rule->data;
            }
            $agents = $this->repository->searchForJQGRID($searchParams, $sortParams, $additionalParams);
        } else {
            $agents = $this->repository->findAllForJQGRID($page, $offset, $sortParams, $additionalParams);
        }

        $size = (int)$this->repository->searchForJQGRID($searchParams, $sortParams, $additionalParams, true)[0][1];
        $pageCount = ceil($size / $offset);

        return new ArrayCollection($this->serializeAgent($agents)
            ->addMeta('totalItems', $size)
            ->addMeta('pages', $pageCount)
            ->addMeta('page', $page)
            ->toArray());
    }
}