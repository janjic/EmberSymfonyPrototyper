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
 * Class JsonApiAgentOrgchartManagerTrait
 * @package UserBundle\Business\Manager\Agent
 */
trait JsonApiAgentOrgchartManagerTrait
{
    /**
     * @return array
     */
    function loadRootAndChildren()
    {
        $data = $this->repository->loadRootAndChildren();
        $helper = [];
        foreach ($data as $agent) {
            $agent['className'] = strtolower($agent['groupName']);

            $superior = $agent['superior_id'];
            $childrenCount = $agent['childrenCount'];
            unset($agent['superior_id']);
            unset($agent['childrenCount']);

            /** if there is superior add element as child */
            if ($superior != null) {
                $agent['relationship'] = '1'.(sizeof($data) > 2 ? 1 : 0).((int) $childrenCount > 0 ? 1 : 0);
                $helper[$superior]['children'][] = $agent;

            } else if (array_key_exists($agent['id'], $helper)) {
                /** element is root */
                $agent['relationship'] = '001';
                $children = $helper[$agent['id']]['children'];
                $helper[$agent['id']] = $agent;
                $helper[$agent['id']]['children'] = $children;

            } else {
                /** element is root */
                $agent['relationship'] = '001';
                $helper[$agent['id']] = $agent;
            }


        }

        return array_values($helper)[0];
    }

    /**
     * @param $parent
     * @return array
     */
    function loadChildren($parent)
    {
        $data = $this->repository->loadChildren($parent, true);

        $helper['children'] = [];
        $parentAgent = null;
        foreach ($data as $agent) {
            $agent['className'] = strtolower($agent['groupName']);

            if ($agent['id'] == $parent) {

                $user = $this->tokenStorage->getToken()->getUser();
                if ($this->isHQ($user)) {
                    /** if admin is loading element then calculate parent and siblings */
                    if ($agent['parentId'] !== null) {
                        $superior = $this->repository->getEntityReference($agent['parentId']);
                        $parentChildrenCount = $this->repository->childCount($superior, true);
                    } else {
                        $parentChildrenCount = 0;
                    }

                    $parent = $agent['parentId'] == null ? '0' : '1';
                    $siblings = $parentChildrenCount > 1 ? '1' : '0';
                    $children = ((int) $agent['childrenCount'] > 0 ? '1' : '0');
                    $agent['relationship'] = $parent.$siblings.$children;
                } else {
                    /** if agent is loading element then disable siblings and parent */
                    $agent['relationship'] = '00'.((int) $agent['childrenCount'] > 0 ? 1 : 0);
                }

                unset($agent['childrenCount']);

                $parentAgent = $agent;
            } else {

                $agent['relationship'] = '1'.(sizeof($data) > 2 ? 1 : 0).((int) $agent['childrenCount'] > 0 ? 1 : 0);
                unset($agent['childrenCount']);

                $helper['children'][] = $agent;
            }
        }

        if ($parentAgent) {
            $parentAgent['children'] = $helper['children'];

            return $parentAgent;
        }

        return $helper;
    }

    /** ----------------- New methods ------------------------------------------------------------------------------- */

    /**
     * Load only parent
     * @param $parentId
     * @return array
     */
    function loadOrgchartParent($parentId)
    {
        $agent = $this->repository->loadOrgchartParent($parentId);

        $parentChildrenCount = 0;

        if ($agent['parentId']) {
            $agentEntity = $this->repository->getEntityReference($agent['parentId']);
            $parentChildrenCount = $this->repository->childCount($agentEntity, true);
        }

        $parent = $agent['parentId'] == null ? '0' : '1';
        $siblings = $parentChildrenCount > 1 ? '1' : '0';
        $children = '1';

        $agent['relationship'] = $parent.$siblings.$children;

        $agent['className'] = strtolower($agent['groupName']);
        unset($agent['childrenCount']);

        return $agent;
    }

    /**
     * Load only siblings
     * @param $id
     * @return array
     */
    function loadOrgchartSiblings($id)
    {
        /** @var Agent $agent */
        $agent = $this->repository->findAgentById($id);
        $helper['siblings'] = [];

        if ($superior = $agent->getSuperior()) {
            $data = $this->repository->loadChildren($superior->getId());
            foreach ($data as $agent) {
                /** ignore element that is being searched */
                if ($agent['id'] == $id) {
                    continue;
                }

                $agent['className'] = strtolower($agent['groupName']);

                $agent['relationship'] = '1' . (sizeof($data) > 1 ? 1 : 0) . ((int)$agent['childrenCount'] > 0 ? 1 : 0);
                unset($agent['childrenCount']);

                $helper['siblings'][] = $agent;
            }
        }

        return $helper;
    }

    /**
     * Load parent and siblings
     * @param $id
     * @param bool $ignoreCurrentElement
     * @return array
     */
    function loadFamily($id, $ignoreCurrentElement = false)
    {
        /** @var Agent $agent */
        $agentEntity = $this->repository->findAgentById($id);
        $helper = [];

        if ($superior = $agentEntity->getSuperior()) {
            $data = $this->repository->loadChildren($superior->getId(), true);

            $parentAgent = [];

            foreach ($data as $agent) {
                $agent['className'] = strtolower($agent['groupName']);

                /** skip current agent */
                if ($ignoreCurrentElement && ($agent['id'] == $id)) {
                    continue;
                }

                $parent = $agent['parentId'] == null ? '0' : '1';
                $children = ((int) $agent['childrenCount'] > 0 ? '1' : '0');

                if ($agent['id'] == $superior->getId()) {

                    if ($superior->getSuperior()) {
                        $parentChildrenCount = $this->repository->childCount($superior->getSuperior(), true);
                    } else {
                        $parentChildrenCount = 0;
                    }

                    $siblings = $parentChildrenCount > 1 ? '1' : '0';
                    $agent['relationship'] = $parent.$siblings.$children;

                    $parentAgent = $agent;
                } else {
                    $siblings = sizeof($data) > 2 ? '1' : '0';
                    $agent['relationship'] = $parent.$siblings.$children;

                    $helper[] = $agent;
                }

                unset($agent['childrenCount']);
            }

            $parentAgent['children'] = $helper;

            return $parentAgent;
        }

        return $helper;
    }
}