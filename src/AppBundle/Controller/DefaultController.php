<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    const DEFAULT_USER_PARAM = 'all';
    /**
     * @Route("/api/users/{user_param}", name="api_users", defaults={"user_param": "all"}),
     * @param Request $request
     * @return JsonResponse
     */
    public function apiUserAction(Request $request)
    {
        return new JsonResponse(
            array(
                'users'=>
                    (($param = $request->get('user_param'))=== self::DEFAULT_USER_PARAM) ?
                                $this->getDoctrine()->getRepository('AppBundle:User')->findUsers(null):
                                    (($id = intval($param)) ? $this->getDoctrine()->getRepository('AppBundle:User')->findUsers($id)
                                            :array(
                                                'error' => 'Please provide valid params'
                                            )

            )

        ));
    }
}
