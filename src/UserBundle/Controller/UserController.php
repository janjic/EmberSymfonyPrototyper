<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use NilPortugues\Api\JsonApi\Http\Request\Parameters\Fields;
use NilPortugues\Symfony\JsonApiBundle\Serializer\JsonApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class UserController extends Controller
{

    const DEFAULT_USER_PARAM = 'all';
    use JsonApiResponseTrait;

    /**
     * @Route("/api/users/{user_param}", name="api_users", defaults={"user_param": "all"}),
     * @param Request $request
     * @return Response
     */
    public function apiUserAction(Request $request)
    {

        if($request->isMethod('PUT')){
            $this->get('agent_system.user_manager')->edit(json_decode($request->getContent())->user, $request->get('user_param'));
            return;
        }

        $serializer = $this->get('nil_portugues.serializer.json_api_serializer');

        if ($userId = intval($request->get('user_param'))) {
            $user = $this->getDoctrine()->getRepository('UserBundle:User')->findUsersObject($userId);
            return $this->response($serializer->serialize($user));
        }

        $params = null;
        $searchParams = null;
        if (($page = $request->get('page')) && ($offset = $request->get('offset'))) {
            $searchFields = array('id'=>'user.id', 'username'=>'user.username', 'firstName'=>'user.firstName', 'lastName'=>'user.lastName');
            $sortParams = array($searchFields[$request->get('sidx')], $request->get('sord'));
            $params['page'] =  $page;
            $params['offset'] =  $offset;

            if ($filters = $request->get('filters')) {
                $searchParams= array(array('toolbar_search'=>true, 'rows'=>$offset, 'page'=>$page), array());
                foreach ($rules = json_decode($filters)->rules as $rule) {
                    $searchParams[1][$searchFields[$rule->field]] = $rule->data;
                }

                $users = $this->getDoctrine()->getRepository('UserBundle:User')->searchUsersForJQGRID($searchParams, $sortParams);
            } else {
                $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAllUsersForJQGRID($page, $offset, $sortParams);
            }

            $size = (int) $this->getDoctrine()->getRepository('UserBundle:User')->searchUsersForJQGRID($searchParams, $sortParams, true)[0][1];
            $pageCount = ceil($size/$offset);

            /** @var \NilPortugues\Api\JsonApi\JsonApiTransformer $transformer */
            $transformer = $serializer->getTransformer();
            $transformer->addMeta('totalItems', $size);
            $transformer->addMeta('pages', $pageCount);
            $transformer->addMeta('page', $page);

        } else {
            $users = $this->getDoctrine()->getRepository('UserBundle:User')->findUsersObject();
        }

        /**return JSON Response */
        return $this->response($serializer->serialize($users));

//        return new JsonResponse(
//            array(
//                'users'=>
//                    (($param = $request->get('user_param'))=== self::DEFAULT_USER_PARAM) ?
//                        $this->getDoctrine()->getRepository('UserBundle:User')->findUsers(null):
//                        (($id = intval($param)) ? $this->getDoctrine()->getRepository('UserBundle:User')->findUsers($id)
//                            :array(
//                                'error' => 'Please provide valid params'
//                            )
//
//                        )
//
//            ));
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
        return new JsonResponse($userSave->toArray(), $userSave['meta']['code']);
    }


}
