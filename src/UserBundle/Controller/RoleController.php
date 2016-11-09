<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends Controller
{
    /**
     * @Route("/api/roles/all", name="api_roles_all")
     * @param ArrayCollection $roleGetAll
     * @return JsonResponse
     */
    public function allAction(ArrayCollection $roleGetAll)
    {
        return new JsonResponse($roleGetAll->toArray());
    }

    /**
     * @Route("/api/roles/add", name="api_roles_add")
     * @param ArrayCollection $roleAdd
     * @return JsonResponse
     */
    public function addAction(ArrayCollection $roleAdd)
    {
        return new JsonResponse($roleAdd->toArray(), $roleAdd['code']);
    }

    /**
     * @Route("/api/roles/delete/{id}", name="api_roles_delete")
     * @param ArrayCollection $roleDelete
     * @return JsonResponse
     */
    public function deleteAction(ArrayCollection $roleDelete)
    {
        return new JsonResponse($roleDelete->toArray(), $roleDelete['code']);
    }
}
