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
        $data = null;
        if (($param = $request->get('user_param')) === self::DEFAULT_USER_PARAM) {
                $data = $this->getDoctrine()->getRepository('AppBundle:User')->findUsers(null);
        } else {
            if ($id = intval($param)) {
                $data = $this->getDoctrine()->getRepository('AppBundle:User')->findUsers($id);
            }
        }

        return new JsonResponse(
            array(
                'user'=>
                   array(
                       'id'=> '1',
                       'username'=>'admin'
                   )

            )

        );
    }
}
