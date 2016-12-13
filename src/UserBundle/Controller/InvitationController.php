<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvitationController extends Controller
{
    /**
     * @Route("/api/invitations/{id}", name="api_invitations", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $invitationAPI
     * @return Response
     */
    public function invitationsAPIAction(ArrayCollection $invitationAPI)
    {
        $status = array_key_exists(1, $invitationAPI->toArray()) ? $invitationAPI[1] : 200;

        return new JsonResponse($invitationAPI->toArray(), 201);
    }
}
