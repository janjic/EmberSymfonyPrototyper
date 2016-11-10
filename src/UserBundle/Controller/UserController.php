<?php

namespace UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use NilPortugues\Symfony\JsonApiBundle\Serializer\JsonApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $userId = ($id = intval($request->get('user_param'))) ? $id : null;
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findUsersObject($userId);
        $serializer = $this->get('nil_portugues.serializer.json_api_serializer');

        /**return JSON Response */
        return $this->response($serializer->serialize($users));

    }

    /**
     * @Route("/file_upload", name="file_upload"),
     * @param Request $request
     * @return Response
     */
    public function fileUploadAction(Request $request)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->get('service_container')->getParameter('main_upload_dir'), $fileName);

        return new JsonResponse(array(
            'dataUrl' => $this->get('service_container')->get('assets.packages')->getUrl('uploads/'.$fileName)));


        /**return JSON Response */
       // return $this->response($serializer->serialize($users));

    }


    /**
     * @Route("/api/users-jqgrid", name="api_users_jqgrid", defaults={"user_param": "all"}),
     * @param ArrayCollection $userJqgrid
     * @return JsonResponse
     */
    public function indexAction(ArrayCollection $userJqgrid)
    {

        /**return JSON Response */
        return new JsonResponse($userJqgrid->toArray());
    }

    /**
     * @Route("/api/users-test", name="api_users_jqgrid", defaults={"user_param": "all"}),
     * @return Response
     */
    public function indexTestAction()
    {

        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();
        $serializer = $this->get('nil_portugues.serializer.json_api_serializer');
        /**return JSON Response */
        return $this->response($serializer->serialize($users));
    }

}
