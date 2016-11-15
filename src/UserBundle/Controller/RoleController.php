<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends Controller
{
    /**
     * @Route("/api/roles", name="api_roles_all", options={"expose" = true})
     * @Method({"GET"})
     * @param ArrayCollection $roleGetAll
     * @return JsonResponse
     */
    public function allAction(ArrayCollection $roleGetAll)
    {
        return new JsonResponse(array('roles'=>$roleGetAll->toArray()));
    }

    /**
     * @Route("/api/roles", name="api_roles_add", options={"expose" = true})
     * @Method({"POST"})
     * @param ArrayCollection $roleAdd
     * @return JsonResponse
     */
    public function addAction(ArrayCollection $roleAdd)
    {
        return new JsonResponse($roleAdd->toArray(), $roleAdd['meta']['code']);
    }

    /**
     * @Route("/api/roles/{id}", name="api_roles_delete", options={"expose" = true})
     * @Method({"DELETE"})
     * @param ArrayCollection $roleDelete
     * @return JsonResponse
     */
    public function deleteAction(ArrayCollection $roleDelete)
    {
        return new JsonResponse($roleDelete->toArray(), $roleDelete['meta']['code']);
    }

    /**
     * @Route("/api/roles/{id}", name="api_roles_update", options={"expose" = true})
     * @Method({"PUT"})
     * @param ArrayCollection $roleUpdate
     * @return JsonResponse
     */
    public function updateAction(ArrayCollection $roleUpdate)
    {
        return new JsonResponse($roleUpdate->toArray(), $roleUpdate['meta']['code']);
    }
}
