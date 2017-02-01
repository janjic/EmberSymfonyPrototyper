<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AgentOrgchartController
 * @package UserBundle\Controller
 */
class AgentOrgchartController extends Controller
{
    /**
     * @Route("/api/agent_orgchart/{parentId}", name="api_orgchart_agents", options={"expose" = true}, defaults={"parentId": null}),
     * @param ArrayCollection $agentOrgchart
     * @return Response
     */
    public function orgchartAction(ArrayCollection $agentOrgchart)
    {
        return new JsonResponse($agentOrgchart->toArray());
    }

    /**
     * @Route("/api/agent_orgchart/parent/{parentId}", name="api_agents_orgchart_parent", options={"expose" = true}, defaults={"parentId": null}),
     * @param ArrayCollection $agentOrgchartParent
     * @return Response
     */
    public function getParentAction(ArrayCollection $agentOrgchartParent)
    {
        return new JsonResponse($agentOrgchartParent->toArray());
    }

    /**
     * @Route("/api/agent_orgchart/siblings/{id}", name="api_orgchart_agents_siblings", options={"expose" = true}),
     * @param ArrayCollection $agentOrgchartSiblings
     * @return Response
     */
    public function getSiblingsAction(ArrayCollection $agentOrgchartSiblings)
    {
        return new JsonResponse($agentOrgchartSiblings->toArray());
    }

    /**
     * @Route("/api/agent_orgchart/families/{id}", name="api_orgchart_agents_families", options={"expose" = true}),
     * @param ArrayCollection $agentOrgchartFamily
     * @return Response
     */
    public function getFamilyAction(ArrayCollection $agentOrgchartFamily)
    {
        return new JsonResponse($agentOrgchartFamily->toArray());
    }
}
