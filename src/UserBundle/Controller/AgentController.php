<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AgentController
 * @package UserBundle\Controller
 */
class AgentController extends Controller
{

    /**
     * @Route("/api/agent-save", name="api_agent_save", options={"expose" = true}),
     * @param ArrayCollection $agentSave
     * @return JsonResponse
     */
    public function saveAgentAction(ArrayCollection $agentSave)
    {
        /**return JSON Response */
        return new JsonResponse($agentSave->toArray());
    }

    /**
     * @Route("/api/agents/{id}", name="api_agents", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $agentAPI
     * @return Response
     */
    public function agentAPIAction(ArrayCollection $agentAPI)
    {
        return new JsonResponse($agentAPI[0]);
    }

    /**
     * @Route("/api/agents/orgchart/root", name="api_agents_orgchart", options={"expose" = true}),
     * @return Response
     */
    public function dataForOrgchartAction()
    {
        $agents = $this->container->get('agent_system.agent.manager')->loadRootAndChildren();

        return new Response(json_encode($agents[29]));
    }

    /**
     * @Route("/api/agents/orgchart/children/{id}", name="api_agents_orgchart_children", options={"expose" = true}, defaults={"id": null}),
     * @return Response
     */
    public function dataForChildrenOrgchartAction($id)
    {
        $agents = $this->container->get('agent_system.agent.manager')->loadChildren($id);

        return new Response(json_encode($agents));
    }

}
