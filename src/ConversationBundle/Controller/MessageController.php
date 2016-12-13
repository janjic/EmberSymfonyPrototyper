<?php

namespace ConversationBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller
{
    /**
     * @Route("/api/messages/{id}", name="api_messages", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $messageAPI
     * @return JSONResponse
     */
    public function groupAPIAction(ArrayCollection $messageAPI)
    {
        return new JSONResponse($messageAPI->toArray(), array_key_exists('errors', $messageAPI->toArray()) ? 422 : 200);
    }
}
