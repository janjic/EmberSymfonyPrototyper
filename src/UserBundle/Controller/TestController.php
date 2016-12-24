<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TCRUserController
 * @package UserBundle\Controller
 */
class TCRUserController extends Controller
{
    /**
     * @Route("/test", name="test", defaults={"user_param": "all"}),
     * @return JsonResponse
     */
    public function testAction()
    {
        die('kraj');
        /**return JSON Response */
        return new JsonResponse($userJqgrid->toArray());
    }
}