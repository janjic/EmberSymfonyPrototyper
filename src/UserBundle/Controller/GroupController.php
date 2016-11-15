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
     * @Route("/api/groups", name="api_groups_all")
     * @Method({"GET"})
     * @param ArrayCollection $groupGetAll
     * @return Response
     */
    public function allAction(ArrayCollection $groupGetAll)
    {
        return new Response($groupGetAll[0]);
    }

    /**
     * @Route("/api/groups", name="api_groups_add", options={"expose" = true})
     * @Method({"POST"})
     * @param ArrayCollection $groupAdd
     * @return JsonResponse
     */
    public function addAction(ArrayCollection $groupAdd)
    {
        return new JsonResponse($groupAdd->toArray(), $groupAdd['meta']['code']);
    }

    /**
     * @Route("/api/groups/{id}", name="api_groups_delete", options={"expose" = true})
     * @Method({"DELETE"})
     * @param ArrayCollection $groupDelete
     * @return JsonResponse
     */
    public function deleteAction(ArrayCollection $groupDelete)
    {
        return new JsonResponse($groupDelete->toArray(), $groupDelete['meta']['code']);
    }

    /**
     * @Route("/api/groups/{id}", name="api_groups_update", options={"expose" = true})
     * @Method({"PUT"})
     * @param ArrayCollection $groupsUpdate
     * @return JsonResponse
     */
    public function updateAction(ArrayCollection $groupsUpdate)
    {
        return new JsonResponse($groupsUpdate->toArray(), $groupsUpdate['meta']['code']);
    }
}
