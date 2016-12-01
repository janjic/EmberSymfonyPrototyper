<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use NilPortugues\Api\JsonApi\Http\Request\Parameters\Fields;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return new JsonResponse($agentSave->toArray(), $agentSave['meta']['code']);
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


}
