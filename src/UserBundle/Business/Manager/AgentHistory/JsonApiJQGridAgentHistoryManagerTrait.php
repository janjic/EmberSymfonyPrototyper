<?php

namespace UserBundle\Business\Manager\AgentHistory;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class JsonApiJQGridAgentHistoryManagerTrait
 * @package UserBundle\Business\Manager\AgentHistory
 */
trait JsonApiJQGridAgentHistoryManagerTrait
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
            'id'                      => 'agent_history.id',
            'agent.id'                => 'agent.id',
            'agent.fullName'          => 'agent.fullName',
            'changedByAgent.fullName' => 'changed_by_agent.name',
            'changedFrom.name'        => 'changed_from.name',
            'changedTo.name'          => 'changed_to.name',
            'changedToSuspended'      => 'agent_history.changedToSuspended',
            'date'                    => 'agent_history.date',
        );

        $sortParams = array($searchFields[$request->get('sidx')], $request->get('sord'));
        $params['page'] = $page;
        $params['offset'] = $offset;

        if ($filters = $request->get('filters')) {
            $searchParams = array(array('toolbar_search' => true, 'rows' => $offset, 'page' => $page), array());
            foreach ($rules = json_decode($filters)->rules as $rule) {
                $searchParams[1][$searchFields[$rule->field]] = $rule->data;
            }
            $agents = $this->repository->searchForJQGRID($searchParams, $sortParams, ['type'=>$request->get('type')]);
        } else {
            $agents = $this->repository->findAllForJQGRID($page, $offset, $sortParams, ['type'=>$request->get('type')]);
        }

        $size = (int)$this->repository->searchForJQGRID($searchParams, $sortParams, ['type'=>$request->get('type')], true)[0][1];
        $pageCount = ceil($size / $offset);

        return new ArrayCollection($this->serializeAgentHistory($agents, [
            'totalItems'=> $size,
            'pages'=> $pageCount,
            'page'=> $page
        ]));
    }
}