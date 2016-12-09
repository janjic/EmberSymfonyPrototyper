<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoleController extends Controller
{
    /**
     * @Route("/api/roles/{id}", name="api_roles", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $roleAPI
     * @return JSONResponse
     */
    public function roleAPIAction(ArrayCollection $roleAPI)
    {
        return new JSONResponse($roleAPI->toArray(), array_key_exists('errors', $roleAPI->toArray()) ? 422 : 200);
    }
}
