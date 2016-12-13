<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use CoreBundle\Business\Manager\TCRSyncManager;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use FSerializerBundle\services\FJsonApiSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Business\Manager\Agent\JsonApiAgentOrgchartManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiDeleteAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiGetAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiJQGridAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiSaveAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiUpdateAgentManagerTrait;
use UserBundle\Business\Repository\AgentRepository;
use UserBundle\Business\Repository\GroupRepository;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

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
     * @var FJsonApiSerializer $fSerializer
     */
    protected $fSerializer;

    /**
     * @param AgentRepository $repository
     * @param GroupManager $groupManager
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(AgentRepository $repository, GroupManager $groupManager, FJsonApiSerializer $fSerializer)
    {
        $this->repository   = $repository;
        $this->groupManager = $groupManager;
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

        if ($agent instanceof Exception) {
            return $agent;
        } else {
            //TODO: CHECK SYNC
            //$this->syncWithTCRPortal($agent, 'add');
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
     */
    public function syncWithTCRPortal($agent, $action)
    {
        if($action == 'add'){
            $url = 'app_dev.php/en/json/add-agent';
        } else {
            $url = 'app_dev.php/en/json/edit-agent';
        }

        $agentJson = $this->createJsonFromAgentObject($agent, $agent->getId());

        $this->sendDataToTCR($url, $agentJson);
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


    public function serializeAgent($agent)
    {

        return $this->fSerializer->setType('agents')->setDeserializationClass(Agent::class)->serialize($agent, AgentSerializerInfo::$mappings, AgentSerializerInfo::$relations);

    }

    /**
     * @param Request $request
     */
    public function getQueryResult($request)
    {
        $page = $request->query->get('page');
        $offset = $request->query->get('rows');
        $searchParams[0]['toolbar_search'] = true;
        $searchParams[0]['page'] = $page;
        $searchParams[0]['rows'] = $offset;

        $searchParams[1][$request->query->get('field')] = $request->query->get('search');

        $additionalParams['select'] = ['agent.email'];

        $agents = $this->repository->searchForJQGRID($searchParams, null, $additionalParams);

        $size = (int)$this->repository->searchForJQGRID($searchParams, null, $additionalParams, true)[0][1];
        $pageCount = ceil($size / $offset);

        return new ArrayCollection($agents);
        return new ArrayCollection($this->serializeAgent($agents)
            ->addMeta('totalItems', $size)
            ->addMeta('pages', $pageCount)
            ->addMeta('page', $page)
            ->toArray());

    }
}