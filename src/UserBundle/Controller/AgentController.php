<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use NilPortugues\Api\JsonApi\Http\Request\Parameters\Fields;
use NilPortugues\Symfony\JsonApiBundle\Serializer\JsonApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class AgentController extends Controller
{

    use JsonApiResponseTrait;

    /**
     * @Route("/api/agent-save", name="api_agent_save"),
     * @param ArrayCollection $agentSave
     * @return JsonResponse
     */
    public function saveAgentAction(ArrayCollection $agentSave)
    {
        /**return JSON Response */
        return new JsonResponse($agentSave->toArray(), $agentSave['meta']['code']);
    }

    /**
     * @Route("/api/agents/{id}", name="api_agents"),
     * @param ArrayCollection $agentEdit
     * @return JsonResponse
     */
    public function agentEditAction(ArrayCollection $agentEdit)
    {

        return $this->response($agentEdit[0]);
    }


}
