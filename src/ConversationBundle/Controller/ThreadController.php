<?php

namespace ConversationBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
}
