<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    /**
     * @Route("/api/groups/{id}", name="api_groups", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $groupAPI
     * @return Response
     */
    public function groupAPIAction(ArrayCollection $groupAPI)
    {
        $status = array_key_exists(1, $groupAPI->toArray()) ? $groupAPI[1] : 200;

        return new Response($groupAPI[0], $status);
    }
}
