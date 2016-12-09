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
        $data = $this->repository->loadChildren($parent);
        $helper['children'] = [];
        foreach ($data as $agent) {

            $agent['relationship'] = '1'.(sizeof($data) > 1 ? 1 : 0).((int) $agent['childrenCount'] > 0 ? 1 : 0);
            unset($agent['childrenCount']);

            $helper['children'][] = $agent;
        }

        return $helper;
    }
}