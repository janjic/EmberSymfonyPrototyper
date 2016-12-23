<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AgentHistoryController
 * @package UserBundle\Controller
 */
class AgentHistoryController extends Controller
{
    /**
     * @Route("/api/agent-histories/{id}", name="api_agent_history", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $agentHistoryAPI
     * @return JSONResponse
     */
    public function roleAPIAction(ArrayCollection $agentHistoryAPI)
    {
        return new JSONResponse($agentHistoryAPI->toArray(), array_key_exists('errors', $agentHistoryAPI->toArray()) ? 422 : 200);
    }
}
