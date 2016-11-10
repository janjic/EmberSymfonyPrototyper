<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
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
                        $this->getDoctrine()->getRepository('UserBundle:User')->findUsers(null):
                        (($id = intval($param)) ? $this->getDoctrine()->getRepository('UserBundle:User')->findUsers($id)
                            :array(
                                'error' => 'Please provide valid params'
                            )

                        )

            ));
    }


    /**
     * @Route("/api/users-jqgrid", name="api_users_jqgrid", defaults={"user_param": "all"}),
     * @param ArrayCollection $userJqgrid
     * @return JsonResponse
     */
    public function jqgridUsersAction(ArrayCollection $userJqgrid)
    {

        /**return JSON Response */
        return new JsonResponse($userJqgrid->toArray());
    }

    /**
     * @Route("/api/user-save", name="api_users_save"),
     * @param ArrayCollection $userSave
     * @return JsonResponse
     */
    public function saveUserAction(ArrayCollection $userSave)
    {

        /**return JSON Response */
        return new JsonResponse($userSave->toArray());
    }

}
