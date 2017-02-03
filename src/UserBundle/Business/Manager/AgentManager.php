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
use PaymentBundle\Business\Manager\PaymentInfoManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Business\Manager\Agent\JsonApiAgentOrgchartManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiDeleteAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiGetAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiJQGridAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiSaveAgentManagerTrait;
use UserBundle\Business\Manager\Agent\JsonApiUpdateAgentManagerTrait;
use UserBundle\Business\Manager\Agent\RoleCheckerTrait;
use UserBundle\Business\Repository\AgentRepository;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Helpers\RoleHelper;

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
    use RoleCheckerTrait;

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
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param AgentRepository $repository
     * @param GroupManager $groupManager
     * @param FJsonApiSerializer $fSerializer
     * @param EventDispatcherInterface $eventDispatcher
     * @param TokenStorageInterface $tokenStorage
     * @param \Swift_Mailer $mailer
     * @param ContainerInterface $container
     */
    public function __construct(AgentRepository $repository, GroupManager $groupManager, FJsonApiSerializer $fSerializer,
                                EventDispatcherInterface $eventDispatcher, TokenStorageInterface $tokenStorage,  \Swift_Mailer $mailer, ContainerInterface $container)
    {
        $this->repository       = $repository;
        $this->groupManager     = $groupManager;
        $this->fSerializer      = $fSerializer;
        $this->eventDispatcher  = $eventDispatcher;
        $this->tokenStorage     = $tokenStorage;
        $this->mailer           = $mailer;
        $this->container        = $container;
    }

    public function getGroupById($id)
    {
        return $this->groupManager->getGroupById($id);
    }

    /**
     * @return object
     */
    public function getTemplatingEngine()
    {
        return $this->container->get('templating');
    }

    public function getTranslator()
    {
        return $this->container->get('translator');
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
                    $agentId = intval($syncResult->agentId);
                    $agent->setId(intval($agentId));
                    $this->flushDb(true);
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
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
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
     * @param Agent $agent
     * @return bool|array
     */
    public function syncDelete(Agent $agent)
    {
        $url = 'en/json/agent-delete/'.$agent->getId();
        try {
            $syncResult = $this->getContentFromTCR($url, 'DELETE');
            if (is_object($syncResult) && $syncResult->code == 200) {
                return true;
            } else if (is_object($syncResult) && $syncResult->code == 403) {
                return AgentApiResponse::AGENT_DELETE_SYNC_ERROR($syncResult->message);
            } else {
                return AgentApiResponse::AGENT_DELETE_SYNC_ERROR('UNKNOWN');
            }
        } catch (\Exception $exception) {
            return AgentApiResponse::AGENT_DELETE_SYNC_ERROR('UNKNOWN');
        }
    }

    /**
     * @param bool $manually
     */
    public function flushDb($manually=false)
    {
        $this->repository->flushDb($manually);
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
            $url = 'en/json/add-agent';
        } else {
            $url = 'en/json/edit-agent';
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

        $roleCondition = $request->query->get('minRoleCondition');

        if(!is_null($roleCondition)) {
            $searchParams[1]['minRoleCondition'] = $roleCondition;
        }

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
     * @param $roleName
     * @return null|Agent
     */
    public function findAgentByRole($roleName = RoleManager::ROLE_SUPER_ADMIN)
    {
        return $this->repository->findAgentByRole($roleName);
    }

    /**
     * @return ArrayCollection
     */
    public function findSerializedSuperAgent()
    {
        $superAgent =  $this->repository->findAgentByRole();

        return new ArrayCollection($this->serializeAgent($superAgent)->toArray());
    }

    /**
     * @param $id
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     */
    public function getReference($id)
    {
        return $this->repository->getReference($id);
    }

    /**
     * @param Agent $agent
     */
    public function changePassword(Agent $agent)
    {
         $this->passwordManipulator->changePassword($agent->getUsername(), $agent->getPlainPassword());
    }

    /**
     * @return mixed
     */
    public function findAgentsByCountry()
    {

        return $this->repository->findAgentsByCountry();
    }

    /**
     * @return array
     */
    public function newAgentsCount(){
        $agent = $this->getCurrentUser();
        $agent = $this->repository->findAgentByRole()->getId()==$agent->getId() ? null : $agent;

        $today      = $this->repository->newAgentsCount($agent, 'today');
        $this_month = $this->repository->newAgentsCount($agent, 'month');
        $total      = $this->repository->newAgentsCount($agent, 'total');

        return array(
            'today'         => $today,
            'this_month'    => $this_month,
            'total'         => $total
        );
    }

    /**
     * @param $agentId
     * @param $type
     * @return null|Agent
     */
    public function checkNewSuperiorType($agentId, $type)
    {
        $agent      = $this->repository->find($agentId);
        $group      = $this->groupManager->findGroupByName($type);

        return $this->getSuperiorWithSpecifiedGroup($agent, $group);
    }

    /**
     * @param Agent $agent
     * @param Group $group
     * @return null|Agent
     */
    public function getSuperiorWithSpecifiedGroup(Agent $agent, Group $group) {
        /** @var Agent $superior */
        $superior = $agent->getSuperior();
        if (!$superior) {
            return null;
        }

        if ( $superior->getGroup() && $superior->getGroup()->getId() == $group->getId() ) {
            return $superior->getId();
        }

        return $this->getSuperiorWithSpecifiedGroup($superior, $group);
    }

    /**
     * @param $agent
     */
    public function updatePaymentInfoOnAgent(Agent $agent){

        $agent->setPaymentsNumb($agent->getPaymentsNumb() + 1);

        /**
         * @var $superior Agent
         */
        $superior = $agent->getSuperior();
        if($superior->getGroup()->getName() === RoleHelper::MASTER || $superior->getGroup()->getName() === RoleHelper::ACTIVE){
            if(!in_array($agent->getId(), $superior->getActiveAgentsIds())){
                $superior->addActiveAgentId($agent->getId());
            }
        }

        $this->repository->simpleEdit(array($agent, $superior));
    }

    /**
     * @param $request
     * @param bool $isCountSearch
     * @param int $firstRes
     * @param int $maxRes
     * @return array
     */
    public function getDowngradeSuggestionsForActiveAgent($request, $isCountSearch= false, $firstRes = 0, $maxRes = 1)
    {
        return $this->repository->getDowngradeSuggestionsForActiveAgent($request, $isCountSearch, $firstRes, $maxRes);
    }

    /**
     * @param $request
     * @param bool $isCountSearch
     * @param int $offset
     * @return array
     */
    public function getDowngradeSuggestionsForMasterAgent($request, $isCountSearch= false, $offset = 4)
    {
        return $this->repository->getDowngradeSuggestionsForMasterAgent($request, $isCountSearch, $offset);
    }

    /**
     * @param $request
     * @param bool $isCountSearch
     * @param int $offset
     * @return array
     */
    public function getPromotionSuggestionsForActiveAgent($request, $isCountSearch = false, $offset = 4 )
    {
        return $this->repository->getPromotionSuggestionsForActiveAgent($request, $isCountSearch, $offset);
    }

    /**
     * @param $request
     * @param bool $isCountSearch
     * @param int $firstRes
     * @param int $maxRes
     * @return array
     */
    public function getPromotionSuggestionsForReferee($request, $isCountSearch= false, $firstRes = 0, $maxRes = 1)
    {
        return $this->repository->getPromotionSuggestionsForReferee($request, $isCountSearch, $firstRes, $maxRes);
    }

    /**
     * @param Agent $agent
     */
    public function sendNewAgentMail($agent)
    {
        /** @var Agent $user */
        $user     = $this->getCurrentUser();
        $subject  = $this->getTranslator()->trans('Content Republic Agent Portal', array(), null, $agent->getNationality());
        $from     = $user->getEmail();
        $body     = $this->getTemplatingEngine()->render("UserBundle::mail/agent-registration-mail.html.twig", array(
            'agentSender'    => $user,
            'agentRecipient' => $agent
        ));
        $to = $agent->getEmail();

        /** @var \Swift_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}