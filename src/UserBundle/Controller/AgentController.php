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

}
