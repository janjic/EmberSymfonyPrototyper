<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
    /**
     * @Route("/api/notifications/{id}", name="api_notifications", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $notificationsAPI
     * @return Response
     */
    public function invitationsAPIAction(ArrayCollection $notificationsAPI)
    {
        $status = array_key_exists('errors', $notificationsAPI->toArray()) ? $notificationsAPI['errors'][0]['status'] : 201;

        return new JsonResponse($notificationsAPI->toArray(), $status);
    }
}