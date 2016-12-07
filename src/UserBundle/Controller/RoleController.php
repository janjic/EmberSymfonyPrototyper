<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * @Route("/api/roles/{id}", name="api_roles", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $roleAPI
     * @return Response
     */
    public function roleAPIAction(ArrayCollection $roleAPI)
    {
        $status = array_key_exists(1, $roleAPI->toArray()) ? $roleAPI[1] : 200;

        return new Response($roleAPI[0], $status);
    }
}
