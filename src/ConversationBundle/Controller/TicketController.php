<?php

namespace ConversationBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketController extends Controller
{
    /**
     * @Route("/api/tickets/{id}", name="api_tickets", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $ticketAPI
     * @return JSONResponse
     */
    public function groupAPIAction(ArrayCollection $ticketAPI)
    {
        return new JSONResponse($ticketAPI->toArray(), array_key_exists('errors', $ticketAPI->toArray()) ? 422 : 200);
    }
}
