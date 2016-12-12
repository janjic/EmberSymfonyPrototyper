<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupController extends Controller
{
    /**
     * @Route("/api/groups/{id}", name="api_groups", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $groupAPI
     * @return JSONResponse
     */
    public function groupAPIAction(ArrayCollection $groupAPI)
    {
        return new JSONResponse($groupAPI->toArray(), array_key_exists('errors', $groupAPI->toArray()) ? 422 : 200);
    }
}
