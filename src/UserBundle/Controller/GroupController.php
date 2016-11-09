<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends Controller
{
    /**
     * @Route("/api/groups/all", name="api_groups_all")
     * @param ArrayCollection $groupGetAll
     * @return JsonResponse
     */
    public function allAction(ArrayCollection $groupGetAll)
    {
        return new JsonResponse($groupGetAll->toArray());
    }

    /**
     * @Route("/api/groups/add", name="api_groups_add")
     * @param ArrayCollection $groupAdd
     * @return JsonResponse
     */
    public function addAction(ArrayCollection $groupAdd)
    {
        return new JsonResponse($groupAdd->toArray(), $groupAdd['code']);
    }

    /**
     * @Route("/api/groups/delete/{id}/{parentId}", name="api_groups_delete")
     * @param ArrayCollection $groupDelete
     * @return JsonResponse
     */
    public function deleteAction(ArrayCollection $groupDelete)
    {
        return new JsonResponse($groupDelete->toArray(), $groupDelete['code']);
    }
}
