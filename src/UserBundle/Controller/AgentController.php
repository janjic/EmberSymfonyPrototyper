<?php

namespace UserBundle\Controller;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Agent;

/**
 * Class AgentController
 * @package UserBundle\Controller
 */
class AgentController extends Controller
{

    /**
     * @Route("/api/agents/{id}", name="api_agents", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $agentAPI
     * @return Response
     */
    public function agentAPIAction(ArrayCollection $agentAPI)
    {
        return new JsonResponse(($data = $agentAPI->toArray()), array_key_exists('errors', $data)? 422:200);
    }

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
     * @Route("/api/agents/info/{id}" ,name="agent-info",
     * options={"expose" = true})
     * @ParamConverter("agent", class="UserBundle:Agent")
     * @param Agent $agent
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NoResultException
     */
    public function getAgentInfoAction(Agent $agent)
    {
        $childCount = $this->get('agent_system.agent.repository')->childCount($agent, true/*direct*/);

        $url = 'en/json/get-jqgrid-user-all?rows=10&page=1&sidx=id&sord=asc&agentId='.$agent->getAgentId();

        $resp = $this->get('agent_system.tcr_user_manager')->getContentFromTCR($url);
        return new JsonResponse(AgentApiResponse::AGENT_INFO_OK_RESPONSE($childCount, $resp->description->totalCount));
    }

    /**
     * @Route("/api/agents/newAgentsInfo/{id}" ,name="new-agents-info",
     * options={"expose" = true})
     * @ParamConverter("agent", class="UserBundle:Agent")
     * @param Agent $agent
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNewAgentsInfoAction(Agent $agent)
    {
        $agent = $this->get('agent_system.agent.repository')->findAgentByRole()->getId()==$agent->getId() ? null : $agent;

        $newAgentsToday         = $this->get('agent_system.agent.repository')->newAgentsCount($agent, 'today');
        $newAgentsThisMonth     = $this->get('agent_system.agent.repository')->newAgentsCount($agent, 'month');
        $newAgentsTotal         = $this->get('agent_system.agent.repository')->newAgentsCount($agent, 'total');

        return new JsonResponse(AgentApiResponse::NEW_AGENTS_INFO_OK_RESPONSE($newAgentsToday, $newAgentsThisMonth, $newAgentsTotal));
    }

}
