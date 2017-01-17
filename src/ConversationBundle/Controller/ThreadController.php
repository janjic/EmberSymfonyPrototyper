<?php

namespace ConversationBundle\Controller;

use CoreBundle\Adapter\AgentApiCode;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\Agent;

/**
 * Class ThreadController
 * @package ConversationBundle\Controller
 */
class ThreadController extends Controller
{
    /**
     * @Route("/api/threads/{id}", name="api_threads", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $threadAPI
     * @return JSONResponse
     */
    public function threadAPIAction(ArrayCollection $threadAPI)
    {
        return new JSONResponse($threadAPI->toArray(), array_key_exists('errors', $threadAPI->toArray()) ? 422 : 200);
    }

    /**
     * @Route("/api/newMessagesInfo" ,name="new-messages-info",
     * options={"expose" = true})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNewPaymentsInfoAction()
    {
        $newCommissionsInfo = $this->get('agent_system.thread.manager')->newMessagesCount();

        return new JsonResponse(array('data' => $newCommissionsInfo, 'status' => AgentApiCode::MESSAGES_NEW_INFO));
    }
}
