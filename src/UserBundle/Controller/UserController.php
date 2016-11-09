<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
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
     * @param ArrayCollection $usersJQgrid
     * @return JsonResponse
     */
    public function indexAction(ArrayCollection $userJqgrid)
    {

        /**return JSON Response */
        return new JsonResponse($userJqgrid->toArray());
    }

    /**
     * @Route("/testtt", name="testt", defaults={"user_param": "all"}),
     * @return JsonResponse
     */
    public function testAction()
    {
        Debug::dump($this->container->get('agent_system.role.manager')->getAll());die();
    }
}
