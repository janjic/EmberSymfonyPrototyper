<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SettingsController extends Controller
{
    /**
     * @Route("/api/settings/{id}", name="api_settings", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $settingsAPI
     * @return Response
     */
    public function settingsAPIAction(ArrayCollection $settingsAPI)
    {
        $status = array_key_exists('errors', $settingsAPI->toArray()) ? $settingsAPI['errors'][0]['status'] : 200;

        return new JsonResponse($settingsAPI->toArray(), $status);
    }
}
