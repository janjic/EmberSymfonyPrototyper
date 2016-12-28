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

        /** @var Agent $user */
        $user = $this->tokenStorage->getToken()->getUser();
        /**
         * CHECK IF SUPER ADMIN AND DONT ADD FILTERS
         */
        if ( $this->repository->findAgentByRole() && $this->repository->findAgentByRole()->getId() == $user->getId()) {
            $promoCode = null;
        }else{
            $promoCode = $user->getAgentId();
        }

        if ($filters = $request->get('filters')) {
            $searchParams = array(array('toolbar_search' => true, 'rows' => $offset, 'page' => $page), array());
            $filters = json_decode($filters);
            if ($filters->groupOp == 'or') {
                $additionalParams['or'] = true;
            }
            foreach ($rules = $filters->rules as $rule) {
                $searchParams[1][$searchFields[$rule->field]] = $rule->data;
            }
            $agents = $this->repository->searchForJQGRID($searchParams, $sortParams, $additionalParams, false, $promoCode);
        } else {
            $agents = $this->repository->findAllForJQGRID($page, $offset, $sortParams, $additionalParams, $promoCode);
        }

        $size = (int)$this->repository->searchForJQGRID($searchParams, $sortParams, $additionalParams, true, $promoCode)[0][1];
        $pageCount = ceil($size / $offset);

        return new ArrayCollection($this->serializeAgent($agents)
            ->addMeta('totalItems', $size)
            ->addMeta('pages', $pageCount)
            ->addMeta('page', $page)
            ->toArray());
    }
}