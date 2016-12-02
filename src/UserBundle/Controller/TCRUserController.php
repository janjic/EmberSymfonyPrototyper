<?php

namespace UserBundle\Controller;

use CoreBundle\Business\Serializer\FSDSerializer;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use UserBundle\Business\Schema\Agent\AgentSimpleSchema;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\TCRUser;

class TCRUserController extends Controller
{
    /**
     * @Route("/api/tcr-users/{id}", name="api_tcr_users", options={"expose" = true}, defaults={"id": "all"}),
     * @param ArrayCollection $tCRUserAPI
     * @return Response
     */
    public function roleAPIAction(ArrayCollection $tCRUserAPI)
    {
        $status = array_key_exists(1, $tCRUserAPI->toArray()) ? $tCRUserAPI[1] : 200;

        return new Response($tCRUserAPI[0], $status);
    }


//    /**
//     * @Route("/api/tcr-users/{user_param}", name="api_tcr_users", defaults={"user_param": "all"}),
//     * @param Request $request
//     * @return Response
//     */
    public function apiUsersAction(Request $request)
    {

        $url = 'en/json/get-jqgrid-user-all?rows=10&page=1&sidx=id&sord=asc';
        $url.= 'rows='.$request->get('offset');
        $url.= '&page='.$request->get('page');
        $url.= '&sidx='.$request->get('sidx');
        $url.= '&sord='.$request->get('sord');

        if ($filters = json_decode($request->get('filters'), true)) {
            foreach ($filters['rules'] as &$rule) {
                $rule['field'] = $this->changeToTCRFormat($rule['field']);
            }
            $url.= '&_search=true';
            $url.= '&filters='.json_encode($filters);
        }

        /** @var Agent $user */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if (!$user->hasRole('ROLE_ADMIN')){
            $url.= '&agentId='.$user->getAgentId();
        };

        $resp = $this->container->get('agent_system.tcr_user_manager')->getContentFromTCR($url);
        $users = array();

        foreach ($resp->items as $user) {
            $new = new TCRUser();
            foreach ($user as $key => $value) {
                $new->setPropertyValue($key, $user->{$key});
            }

            $users[] = $new;
        }



        $meta = [
            'totalItems' => $resp->description->totalCount,
            'pages'      => $resp->description->pageCount,
            'page'       => $resp->description->current
        ];

        return new Response(FSDSerializer::serialize($users, $meta));
    }
//
//    public function changeToTCRFormat($key){
//        $rules = [
//            'firstName' => 'name',
//            'lastName' => 'surname'
//        ];
//
//        return array_key_exists($key, $rules) ? $rules[$key] : $key;
//    }
//
//    /**
//     * @Route("/api/tcr-user/{id}", name="api_get_tcr_user"),
//     * @Method({"GET"})
//     * @param Request $request
//     * @return Response
//     */
//    public function apiUserAction(Request $request)
//    {
//        $id = $request->get('id');
//
//        $url = 'app_dev.php/sr/json/user/'.$id;
//
//        $manager = $this->container->get('agent_system.tcr_user_manager');
//        $resp = $manager->getContentFromTCR($url);
//
//        $user = new TCRUser();
//        foreach ($resp as $key => $value) {
//            $user->setPropertyValue($manager->dashesToCamelCase($key), $value);
//        }
//
//        if ($avatar = $user->getAvatar()) {
//            $image = new Image();
//            $image->setId($avatar->id);
//            $image->setFilePath($avatar->web_path);
//            $image->setName($avatar->name);
//
//            $user->setAvatar($image);
//        }
//        $user->setFirstName($user->getName());
//        $user->setLastName($user->getSurname());
//        if ($agentObj = $user->getAgent()) {
//            $agent = $this->get('agent_system.agent.manager')->findAgentById($agentObj->id);
//            $user->setAgent($agent);
//        }
//
//        $relations = array();
//        //LINKS AND META ARE OPTIONALS
//        $mappings =
//            array(
//                'tcr-users' => array('class' => TCRUser::class, 'type'=>'tcr-users'),
//            );
//
//        $serialized = $this->get('f_serializer')->serialize($user, $mappings, $relations);
//
//        return new JsonResponse($serialized);
//
//    }
//
//
//    /**
//     * @Route("/api/tcr-user/{id}", name="api_update_tcr_user"),
//     * @Method({"PATCH"})
//     * @param Request $request
//     * @return Response
//     */
//    public function apiUpdateAction(Request $request)
//    {
//        $manager = $this->container->get('agent_system.tcr_user_manager');
//        $content = json_decode($request->getContent());
//
//        $data = $content->data->attributes;
//
//        foreach ($data as $key => $value) {
//            $newKey = $manager->middleDashesToLower($key);
//            if (!property_exists($data, $newKey)) {
//                $data->{$newKey} = $value;
//                unset($data->{$key});
//            }
//        }
//
//        // adjust rest
//        $data->id = $request->get('id');
//        $data->name = $data->first_name;
//        $data->surname = $data->last_name;
//        $data->roleAdmin = $data->is_admin;
//        $data->money_add = "";
//
//        $date = new \DateTime($data->birth_date);
//
//        $data->birth_date = $date->format(DateTime::ISO8601);
//
//        if ($imgData = $content->data->relationships->image->data) {
//            $data->avatar = $imgData->attributes;
//            $data->avatar->id = $imgData->id;
//        }
//
//        unset($data->first_name);
//        unset($data->last_name);
//        unset($data->is_admin);
//        unset($data->avatar->type);
//        unset($data->username);
//
//        $url = 'app_dev.php/en/json/edit-user';
//        $manager = $this->container->get('agent_system.tcr_user_manager');
//        $resp = $manager->sendDataToTCR($url, json_encode($data));
//
////        var_dump($resp);die();
//        if($resp->code == 200) {
//            return new JsonResponse(array(
//                'data' => array('type'=> 'agents'),
//                'meta' => array('code'=> 200, 'message' => 'User successfully saved')));
//        } else {
//            return new JsonResponse(array(
//                'user' => array('id' => null),
//                'meta' => array('code'=> 500, 'message' => 'User not saved')));
//        }
//    }
//
//    /**
//     * @Route("/api/tcr-user/save", name="api_save_tcr_user"),
//     * @Method({"POST"})
//     * @param Request $request
//     * @return Response
//     */
//    public function apiSaveAction(Request $request)
//    {
//        $manager = $this->container->get('agent_system.tcr_user_manager');
//        $content = json_decode($request->getContent());
//
//        $data = $content->data->attributes;
//
//        foreach ($data as $key => $value) {
//            $newKey = $manager->middleDashesToLower($key);
//            if (!property_exists($data, $newKey)) {
//                $data->{$newKey} = $value;
//                unset($data->{$key});
//            }
//        }
//
//        $data->password = $data->plain_password;
//        $data->name = $data->first_name;
//        $data->surname = $data->last_name;
//        $data->roleAdmin = $data->is_admin;
//        $data->money_add = "";
//
//        if ($imgData = $content->data->relationships->image->data) {
//            $data->avatar = $imgData->attributes;
//            $data->avatar->id = $imgData->id;
//        }
//
//        $date = new \DateTime($data->birth_date);
//
//        $data->birth_date = $date->format(DateTime::ISO8601);
//
//        unset($data->first_name);
//        unset($data->last_name);
//        unset($data->is_admin);
//        unset($data->avatar->type);
//        unset($data->username);
//
//        $url = 'app_dev.php/en/json/register';
//        $manager = $this->container->get('agent_system.tcr_user_manager');
//
//        $resp = $manager->sendDataToTCR($url, json_encode($data));
//
//        if($resp->code == 200) {
//            return new JsonResponse(array(
//                'data' => array('type'=> 'agents'),
//                'meta' => array('code'=> 200, 'message' => 'User successfully saved')));
//        } else {
//            return new JsonResponse(array(
//                'user' => array('id' => null),
//                'meta' => array('code'=> 500, 'message' => 'User not saved')));
//        }
//    }
}
