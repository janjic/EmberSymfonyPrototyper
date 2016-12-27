<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use CoreBundle\Business\Manager\TCRSyncManager;
use FSerializerBundle\Serializer\JsonApiOne;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\Agent;
use UserBundle\Entity\TCRUser;
use UserBundle\Entity\Document\Image;
use DateTime;

/**
 * Class TCRUserManager
 * @package UserBundle\Business\Manager
 */
class TCRUserManager extends TCRSyncManager implements JSONAPIEntityManagerInterface
{
    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var AgentManager
     */
    protected $agentManager;

    /**
     * TCRUserManager constructor.
     * @param FJsonApiSerializer $fSerializer
     * @param TokenStorageInterface $tokenStorage
     * @param AgentManager $agentManager
     */
    public function __construct(FJsonApiSerializer $fSerializer, TokenStorageInterface $tokenStorage, AgentManager $agentManager)
    {
        $this->fSerializer = $fSerializer;
        $this->tokenStorage = $tokenStorage;
        $this->agentManager = $agentManager;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function jqgridAction($request)
    {
        $url = 'en/json/get-jqgrid-user-all?';
        $url.= 'rows='.$request->get('offset');
        $url.= '&page='.$request->get('page');
        $url.= '&sidx='.$request->get('sidx');
        $url.= '&sord='.$request->get('sord');
        $promoCode = $request->get('promoCode');//AGENT ID FOR FILTER

        if ($filters = json_decode($request->get('filters'), true)) {
            foreach ($filters['rules'] as &$rule) {
                $rule['field'] == 'firstName' ? $rule['field'] = "name" : null;
                $rule['field'] == 'lastName' ? $rule['field'] = "surname" : null;
            }
            $url.= '&_search=true';
            $url.= '&filters='.json_encode($filters);
        }

        if( $promoCode ){
            $url .= '&agentId=' . $promoCode;
        } else {
            /** @var Agent $user */
            $user = $this->tokenStorage->getToken()->getUser();
            if (!$user->hasRole('ROLE_SUPER_ADMIN')) {
                $url .= '&agentId=' . $user->getAgentId();
            };
        }

        $resp = $this->getContentFromTCR($url);

        $users = array();
        if ($resp->items) {
            foreach ($resp->items as $user) {
                $new = new TCRUser();
                foreach ($user as $key => $value) {
                    $key = $key == 'name' ? 'firstName' : $key;
                    $key = $key == 'surname' ? 'lastName' : $key;

                    $new->setPropertyValue($key, $value);
                }
                $users[] = $new;
            }
        }

        $meta = [
            'totalItems' => $resp->description->totalCount,
            'pages'      => $resp->description->pageCount,
            'page'       => $resp->description->current
        ];

        return $this->serializeTCRUser($users, $meta);
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getResource($id = null)
    {
        $resp = $this->getContentFromTCR('app_dev.php/sr/json/user/'.$id);

        $user = new TCRUser();
        foreach ($resp as $key => $value) {
            $key = $key == 'name' ? 'firstName' : $key;
            $key = $key == 'surname' ? 'lastName' : $key;

            $user->setPropertyValue($this->dashesToCamelCase($key), $value);
        }

        if ( property_exists($resp, 'avatar') ) {
            $avatar = $resp->avatar;
            $user->setImageId($avatar->id);
            $user->setImageName($avatar->name);
            $user->setFilePath($avatar->web_path);
        }

        unset($user->avatar);

        if ($agentObj = $user->getAgent()) {
            $agent = $this->agentManager->findAgentById($agentObj->id);
            $user->setAgent($agent);
        }

        $user->setBirthDate(new \DateTime($user->getBirthDate()));

        return $this->serializeTCRUser($user);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function saveResource($data)
    {
        $content = json_decode($data);
        $data = $content->data->attributes;

        $promoCode = $content->data->relationships->agent->data->attributes->agent_id;

        foreach ($data as $key => $value) {
            $newKey = $this->middleDashesToLower($key);
            if (!property_exists($data, $newKey)) {
                $data->{$newKey} = $value;
                unset($data->{$key});
            }
        }

        $data->password = $data->plainPassword;
        $data->name = $data->firstName;
        $data->surname = $data->lastName;
        $data->roleAdmin = $data->isAdmin;
        $data->phone_number = $data->phoneNumber;
        $data->money_add = "";
        $data->promoCode = $promoCode;

        if( $data->imageName !=null ){
            $data->avatar = array(
                "name" => $data->imageName,
                "base64_content" => $data->base64Content
            );
        } else {
            $data->avatar = null;
        }

        unset($data->base64Content);
        unset($data->imageName);

        $date = new \DateTime($data->birthDate);

        $data->birth_date = $date->format(DateTime::ISO8601);

        unset($data->firstName);
        unset($data->lastName);
        unset($data->isAdmin);
        unset($data->avatar->type);
        unset($data->username);
        unset($data->phoneNumber);

        $resp = $this->sendDataToTCR('app_dev.php/en/json/register', json_encode($data));

        if($resp->code == 200) {
            return array(array('data' => array('id' => $resp->id, "type" => "tcr-users")), 201);
        } else if($resp->code == 424){
            return array(array('errors' => array(array('status' => 422, 'detail' => $resp->status))), 400);
        } else {
            return array(array('errors' => array(array('status' => 500, 'detail' => 'Internal server error. Data not saved.'))), 500);
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function updateResource($data)
    {
        $content = json_decode($data);
        $data = $content->data->attributes;

        foreach ($data as $key => $value) {
            $newKey = $this->middleDashesToLower($key);
            if (!property_exists($data, $newKey)) {
                $data->{$newKey} = $value;
                unset($data->{$key});
            }
        }

        // adjust rest
        $data->id = $content->data->id;
        $data->name = $data->firstName;
        $data->surname = $data->lastName;
        $data->roleAdmin = $data->isAdmin;
        $data->phone_number = $data->phoneNumber;
        $data->money_add = "";

        $date = new \DateTime($data->birthDate);
        $data->birth_date = $date->format(DateTime::ISO8601);

        if( $data->imageName != null){
            if( $data->imageId ) {
                $data->avatar = array(
                    "id" => $data->imageId,
                    "name" => $data->imageName
                );
            } else {
                $data->avatar = array(
                    "name" => $data->imageName,
                    "base64_content" => $data->base64Content
                );
            }
        } else {
            $data->avatar = null;
        }

        unset($data->base64Content);
        unset($data->imageName);

        unset($data->firstName);
        unset($data->lastName);
        unset($data->isAdmin);
        unset($data->avatar->type);
        unset($data->avatar->file_path);
        unset($data->username);
        unset($data->phoneNumber);

        unset($data->baseImageUrl);
        unset($data->password);
        unset($data->passwordRepeat);
        unset($data->plainPassword);
        unset($data->emailRepeat);
        unset($data->birthDate);

        $url = 'app_dev.php/en/json/edit-user';
        $resp = $this->sendDataToTCR($url, json_encode($data));

        if($resp->status == 200) {
            return array(array('meta' => array('message'=>'User successfully saved')), 204);
        } else {
            return array(array('errors' => array('message'=>'Error occurred')), 500);
        }
    }

    /**
     * @param null $id
     * @return mixed|void
     * @throws \Exception
     */
    public function deleteResource($id)
    {
        throw new \Exception('TCR User delete not supported!');
    }

    public function serializeTCRUser($user, $meta = null){
        $mappings = array(
            'tcr-users' => array('class' => TCRUser::class, 'type'=>'tcr-users'),
            'agent' => array('class' => Agent::class, 'type'=>'agents', 'jsonApiType'=> JsonApiOne::class)
        );

        $serialized = $this->fSerializer->setDeserializationClass(TCRUser::class)->serialize($user, $mappings, ['agent']);

        if ($meta) {
            foreach ($meta as $key => $value) {
                $serialized->addMeta($key, $value);
            }
        }

        return $serialized;
    }
}