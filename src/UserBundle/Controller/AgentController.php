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
        return new JsonResponse($agentAPI->toArray());
    }


}
