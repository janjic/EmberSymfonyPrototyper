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
     * @param ArrayCollection $notificationAPI
     * @return Response
     */
    public function invitationsAPIAction(ArrayCollection $notificationAPI)
    {
        $status = array_key_exists('errors', $notificationAPI->toArray()) ? $notificationAPI['errors'][0]['status'] : 200;

        return new JsonResponse($notificationAPI->toArray(), $status);
    }
}