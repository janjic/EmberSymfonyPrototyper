<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use CoreBundle\Business\Manager\TCRSyncManager;
use CoreBundle\Business\Serializer\FSDSerializer;
use DateTime;
use Doctrine\Common\Util\Debug;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Business\Repository\AgentRepository;
use UserBundle\Business\Repository\GroupRepository;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class AgentManager
 * @package UserBundle\Business\Manager
 */
class AgentManager implements JSONAPIEntityManagerInterface
{
    /**
     * @var GroupRepository
     */
    protected $repository;

    protected $groupManager;

    protected $syncManager;

    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @param AgentRepository $repository
     * @param GroupManager $groupManager
     * @param TCRSyncManager $syncManager
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(AgentRepository $repository, GroupManager $groupManager, TCRSyncManager $syncManager, FJsonApiSerializer $fSerializer)
    {
        $this->repository   = $repository;
        $this->groupManager = $groupManager;
        $this->syncManager  = $syncManager;
        $this->fSerializer  = $fSerializer;
    }

    public function getGroupById($id)
    {
        return $this->groupManager->getGroupById($id);
    }

    /**
     * @param Agent $agent
     * @param Agent $superior
     * @return Agent
     */
    public function save(Agent $agent, Agent $superior)
    {
        $agent = $this->repository->saveAgent($agent, $superior);
        if($agent->getId()){
            $this->syncWithTCRPortal($agent, 'add');
        }
        return $agent;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findAgentById($id)
    {
        return $this->repository->findAgentById($id);
    }

    /**
     * @param Agent $agent
     * @param $dbSuperior
     * @param $newSuperior
     * @return Agent
     */
    public function edit(Agent $agent, $dbSuperior, $newSuperior)
    {
        return $this->repository->edit($agent, $dbSuperior, $newSuperior);
    }

    /**
     * @param $request
     */
    public function jqgridAction($request)
    {
        $params = null;
        $searchParams = null;
        if (($page = $request->get('page')) && ($offset = $request->get('offset'))) {
            $searchFields = array('id' => 'agent.id', 'username' => 'agent.username', 'firstName' => 'agent.firstName',
                'lastName' => 'agent.lastName', 'group.name' => 'group.name', 'enabled' => 'agent.enabled', 'address.country' => 'address.country');
            $sortParams = array($searchFields[$request->get('sidx')], $request->get('sord'));
            $params['page'] = $page;
            $params['offset'] = $offset;

            if ($filters = $request->get('filters')) {
                $searchParams = array(array('toolbar_search' => true, 'rows' => $offset, 'page' => $page), array());
                foreach ($rules = json_decode($filters)->rules as $rule) {
                    $searchParams[1][$searchFields[$rule->field]] = $rule->data;
                }
                $agents = $this->repository->searchForJQGRID($searchParams, $sortParams, null);
            } else {
                $agents = $this->repository->findAllForJQGRID($page, $offset, $sortParams, null);
            }

            $size = (int)$this->repository->searchForJQGRID($searchParams, $sortParams, null, true)[0][1];
            $pageCount = ceil($size / $offset);

            return $agents;

            var_dump($agents);
            exit;
            /** @var \NilPortugues\Api\JsonApi\JsonApiTransformer $transformer */
            $transformer = $serializer->getTransformer();
            $transformer->addMeta('totalItems', $size);
            $transformer->addMeta('pages', $pageCount);
            $transformer->addMeta('page', $page);
        }
    }

    /**
     * @param null $id
     * @return array
     */
    public function getResource($id = null)
    {
        return $this->repository->findAgentById($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function saveResource($data)
    {
        // TODO: Implement saveResource() method.
    }

    /**
     * @param $data
     * @return mixed
     */
    public function updateResource($data)
    {

        /**
         * @var Agent $agent
         */
        $agent = $this->deserializeAgent($data);


        $dbAgent = $this->repository->findOneById($agent->getId());

//        var_dump($agent);exit;
        $dbAgent->setTitle($agent->getTitle());
        $dbAgent->setFirstName($agent->getFirstName());
        $dbAgent->setLastName($agent->getLastName());
        $dbAgent->setEmail($agent->getEmail());
        $dbAgent->setUsername($agent->getEmail());



        /**
         * @var Address $dbAddress
         */
        $dbAddress = $dbAgent->getAddress();

        /**
         * @var Address $address
         */
        $address = $agent->getAddress();
        $dbAddress->setStreetNumber($address->getStreetNumber());
        $dbAddress->setCity($address->getCity());
        $dbAddress->setCountry($address->getCountry());
        $dbAddress->setFixedPhone($address->getFixedPhone());
        $dbAddress->setPhone($address->getPhone());
        $dbAddress->setPostcode($address->getPostcode());

//        $agent->setAddress($dbAddress);

        $dbAgent->setBirthDate(new DateTime($agent->getBirthDate()));
        $dbAgent->setUsername($agent->getEmail());

        if(!is_null($agent->getImage()) && $agent->getImage()->getId() == 0) {
            $image = new Image();
            $image->setBase64Content($agent->getImage()->getBase64Content());
            $image->setName($agent->getImage()->getName());

            $image->saveToFile($image->getBase64Content());

            $dbAgent->setImage($image);
        }


//        var_dump($this->repository->findOneById($agent->getId()));exit;
        $dbSuperior = $dbAgent->getSuperior();
        $newSuperior = $this->repository->getReference($agent->getSuperior()->getId());

//        /**
//         * Retrieve agent from database by id
//         * @var $dbAgent Agent
//         */
//        $dbAgent = $this->repository->findOneBy(array('id'=>$data->id));
//        /**
//         * Get agent attributes from request
//         */
//        $agentAttrs = $data->attributes;
//
//        /**
//         * Iterate through properties
//         */
//        foreach ($agentAttrs as $key => $value) {
//            /**
//             * Create function name
//             */
//            $func = 'set' . ucfirst($key);
//            /**
//             * Check if function is callable / if exists
//             */
//            if (is_callable(array($dbAgent, $func)) && !is_null($value)) {
//                switch ($key) {
//                    case 'birthDate':
//                        $dbAgent->$func(new DateTime($value));
//                        break;
//                    case 'plainPassword':
//                        break;
//                    case 'password':
//                        break;
//                    default:
//                        $dbAgent->$func($value);
//                        break;
//                }
//                /**
//                 * Call function with param
//                 */
//
//            }
//        }
//
//        /**
//         * Get address attributes from request
//         */
//        $addressAttrs = $data->relationships->address->data->attributes;
//        /**
//         * Iterate through properties
//         */
//        foreach ($addressAttrs as $key => $value) {
//            /**
//             * Create function name
//             */
//            $func = 'set' . ucfirst($this->dashesToCamelCase($key));
//            /**
//             * Check if function is callable / if exists
//             */
//            if (is_callable(array($dbAgent->getAddress(), $func))) {
//                /**
//                 * Call function with param
//                 */
//                $dbAgent->getAddress()->$func($value);
//            }
//        }
//
//        /**
//         * Get group id
//         */
//        $groupId = $data->relationships->group->data->id;
//
//        /**
//         * If agent group has changed
//         */
//        if ($dbAgent->getGroup()->getId() != $groupId) {
//            /**
//             *  Get group from database
//             */
//            $group = $this->getGroupById($groupId);
//            /**
//             * Set group to agent
//             */
//            $dbAgent->setGroup($group);
//        }
//
//        /**
//         * Find superior agent from Database
//         */
//        $superiorAttrs = $data->relationships->superior->data;
//        /**
//         * Save reference on db superior agent in case we need it in edit
//         */
//        $dbSuperior = $dbAgent->getSuperior();
//
//        $newSuperior = null;
//
//        if (!is_null($superiorAttrs) && !is_null($dbAgent->getSuperior()) && $dbAgent->getSuperior()->getId() != $superiorAttrs->id) {
//            /**
//             * Get superior from database
//             */
//            $newSuperior = $this->repository->getReference($superiorAttrs->id);
//        }
//
//        /**
//         * Get Image Id
//         */
//        $imageId = ($imageData = $data->relationships->image->data)? $imageData->id: null;
//        /**
//         * Check if image has changed
//         */
//        if((is_null($dbAgent->getImage()) || $dbAgent->getImage()->getId() != $imageId)) {
//            if(!is_null($imageData) && property_exists($data->relationships->image->data->attributes, 'base64_content')){
//                /**
//                 * Get data for image
//                 */
//                $imageAttr = $data->relationships->image->data->attributes;
//                /**
//                 * Create image object
//                 */
//                $image = new Image();
//
//                /**
//                 * Populate image object
//                 */
//                $image->setBase64Content($imageAttr->base64_content);
//                $image->setName($imageAttr->name);
//
//                /**
//                 * Save image to file
//                 */
//                $image->saveToFile($image->getBase64Content());
//
//                /**
//                 * Set image to agent
//                 */
//                $dbAgent->setImage($image);
//                $dbAgent->setBaseImageUrl($image->getWebPath());
//            } else {
//                $dbAgent->setImage(null);
//                $dbAgent->setBaseImageUrl(null);
//            }
//
//        }
//
//        /**
//         * Edit agent
//         */
        $agent = $this->edit($dbAgent, $dbSuperior, $newSuperior);

        if($agent->getId()){
            $this->syncWithTCRPortal($agent, 'edit');
        }

        return $agent;
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function deleteResource($id = null)
    {
        // TODO: Implement deleteResource() method.
    }


    /**
     * @param $string
     * @param bool $capitalizeFirstCharacter
     * @return mixed
     */
    function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    /**
     * @param $usernameOrEmail
     * @return mixed
     */
    public function loadUserForProvider($usernameOrEmail)
    {
        return $this->repository->getUserForProvider($usernameOrEmail);
    }

    /**
     * @param UserInterface $user
     */
    public function refreshUserForProvider(UserInterface $user)
    {
        return $this->repository->refreshUser($user);
    }

    /**
     * @param $class
     * @return mixed
     */
    public function checkIsClassSupportedForProvider($class)
    {
        return $this->checkIsClassSupportedForProvider($class);
    }

    /**
     * @param $agent
     * @param $action
     */
    function syncWithTCRPortal($agent, $action)
    {
        if($action == 'add'){
            $url = 'app_dev.php/en/json/add-agent';
        } else {
            $url = 'app_dev.php/en/json/edit-agent';
        }

        $agentJson = $this->createJsonFromAgentObject($agent, $agent->getId());

        $this->syncManager->sendDataToTCR($url, $agentJson);
    }
    /**
     * @param Agent $agent
     * @param null $id
     * @return string
     */
    function createJsonFromAgentObject(Agent $agent, $id = null)
    {
        $agentArray = [];
        if(!is_null($id)){
            $agentArray['id'] = $agent->getId();
        }
        $agentArray['agent_id'] = $agent->getAgentId();
        $agentArray['agent_type'] = $agent->getGroup()->getName();
        $agentArray['company'] = '';
        $agentArray['comment'] = $agent->getAgentBackground();
        $agentArray['country'] = $agent->getAddress()->getCountry();
        $agentArray['email'] = $agent->getEmail();
        $agentArray['first_name'] = $agent->getFirstName();
        $agentArray['last_name'] = $agent->getLastName();
        $agentArray['phone_number'] = $agent->getAddress()->getPhone();

        return json_encode($agentArray);
    }


    public function deserializeAgent($content, $mappings = null, $relations = array())
    {
        $relations = array('group', 'superior', 'image', 'address');

        if(!$mappings){
            $mappings =
                array(
                    'agent'    => array('class' => Agent::class, 'type'=>'agents'),
                    'group'    => array('class' => Group::class,  'type'=>'groups'),
                    'superior' => array('class' => Agent::class,  'type'=>'agents'),
                    'image'    => array('class' => Image::class,  'type'=>'images'),
                    'address'  => array('class' => Address::class, 'type'=>'address')
                );
        }


        return $this->fSerializer->deserialize($content,$mappings, $relations);
    }


    function serializeAgent($agent)
    {
        $relations = array('group', 'superior', 'group.roles', 'image', 'address');
        //LINKS AND META ARE OPTIONALS
        $mappings =
            array(
                'agent'    => array('class' => Agent::class, 'type'=>'agents'),
                'group'    => array('class' => Group::class,  'type'=>'groups'),
                'superior' => array('class' => Agent::class,  'type'=>'agents'),
                'roles'    => array('class' => Role::class,   'type'=>'roles'),
                'image'    => array('class' => Image::class,  'type'=>'images'),
                'address'  => array('class' => Address::class, 'type'=>'address')
            );

        $serialized = $this->fSerializer->setType('agents')->setDeserializationClass(Agent::class)->serialize($agent, $mappings, $relations);

        return $serialized;
    }
}