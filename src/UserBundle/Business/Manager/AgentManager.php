<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Adapter\AgentApiResponse;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use CoreBundle\Business\Manager\TCRSyncManager;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use FOS\UserBundle\Util\UserManipulator;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Business\Manager\Agent\JsonApiAgentOrgchartManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiDeleteAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiGetAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiJQGridAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiSaveAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiUpdateAgentManagerTrait;
use UserBundle\Business\Repository\AgentRepository;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;

/**
 * Class AgentManager
 * @package UserBundle\Business\Manager
 */
class AgentManager extends TCRSyncManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiSaveAgentManagerTrait;
    use JsonApiGetAgentManagerTrait;
    use JsonApiUpdateAgentManagerTrait;
    use JsonApiDeleteAgentManagerTrait;
    use JsonApiJQGridAgentManagerTrait;
    use JsonApiAgentOrgchartManagerTrait;

    /**
     * @var AgentRepository
     */
    protected $repository;

    /**
     * @var GroupManager
     */
    protected $groupManager;

    /**
     * @var UserManipulator
     */
    protected $passwordManipulator;

    /**
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @var EventDispatcherInterface $eventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @param AgentRepository $repository
     * @param GroupManager $groupManager
     * @param FJsonApiSerializer $fSerializer
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(AgentRepository $repository, GroupManager $groupManager, FJsonApiSerializer $fSerializer, EventDispatcherInterface $eventDispatcher)
    {
        $this->repository       = $repository;
        $this->groupManager     = $groupManager;
        $this->fSerializer      = $fSerializer;
        $this->eventDispatcher  = $eventDispatcher;
    }

    public function getGroupById($id)
    {
        return $this->groupManager->getGroupById($id);
    }

    /**
     * @param Agent $agent
     * @param Agent $superior
     * @return Agent|Exception|array
     */
    public function save(Agent $agent, Agent $superior)
    {
        $agent = $this->repository->saveAgent($agent, $superior);

        if ($agent instanceof Exception) {
            return $agent;
        } else {
            try {
                $syncResult = $this->syncWithTCRPortal($agent, 'add');
                if (is_object($syncResult) && $syncResult->code == 200) {
                    $this->flushDb();
                } else {
                    return AgentApiResponse::AGENT_SYNC_ERROR_RESPONSE;
                }
            } catch (\Exception $exception) {
                return AgentApiResponse::AGENT_SYNC_ERROR_RESPONSE;
            }
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
     * Flush the db
     */
    public function flushDb(){
        $this->repository->flushDb();
    }


    /**
     * @param $string
     * @param bool $capitalizeFirstCharacter
     * @return mixed
     */
    public function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
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

    /***
     * @param UserInterface $user
     * @return Agent
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
     * @return mixed
     */
    public function syncWithTCRPortal($agent, $action)
    {
        if($action == 'add'){
            $url = 'app_dev.php/en/json/add-agent';
        } else {
            $url = 'app_dev.php/en/json/edit-agent';
        }

        $agentJson = $this->createJsonFromAgentObject($agent, $agent->getId());

        return $this->sendDataToTCR($url, $agentJson);
    }
    /**
     * @param Agent $agent
     * @param null $id
     * @return string
     */
    public function createJsonFromAgentObject(Agent $agent, $id = null)
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


    public function deserializeAgent($content, $mappings = null, $relations = array(), $disabledAttributes = array())
    {

        if (!$relations) {
            $relations = array('group', 'superior', 'image', 'address');
        }

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

        if (!$disabledAttributes) {
            $disabledAttributes = AgentSerializerInfo::$disabledAttributes;
        }

        $this->fSerializer->setDisabledAttributes($disabledAttributes);


        return $this->fSerializer->deserialize($content,$mappings, $relations);
    }

    /**
     * @param $agent
     * @return \FSerializerBundle\Serializer\JsonApiDocument
     */
    public function serializeAgent($agent)
    {

        return $this->fSerializer->setType('agents')->setDeserializationClass(Agent::class)->serialize($agent, AgentSerializerInfo::$mappings, AgentSerializerInfo::$relations, array(),AgentSerializerInfo::$basicFields);

    }

    /**
     * @param $request
     * @return ArrayCollection
     */
    public function getQueryResult($request)
    {
        $page = $request->query->get('page');
        $offset = $request->query->get('rows');
        $searchParams[0]['toolbar_search'] = true;
        $searchParams[0]['page'] = $page;
        $searchParams[0]['rows'] = $offset;

        $searchParams[1][$request->query->get('searchField')] = $request->query->get('search');
        $agents = $this->repository->searchForJQGRID($searchParams, null, []);

        $size = (int)$this->repository->searchForJQGRID($searchParams, null, [], true)[0][1];
        $pageCount = ceil($size / $offset);

        return new ArrayCollection($this->serializeAgent($agents)
            ->addMeta('total', $size)
            ->addMeta('pages', $pageCount)
            ->addMeta('page', $page)
            ->toArray());

    }

    /**
     * @return null|Agent
     */
    public function findAgentByRole()
    {
        return $this->repository->findAgentByRole();
    }

    /**
     * @param $id
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     */
    public function getReference($id)
    {
        return $this->repository->getReference($id);
    }

    public function changePassword(Agent $agent)
    {
         $this->passwordManipulator->changePassword($agent->getUsername(), $agent->getPlainPassword());
    }
}