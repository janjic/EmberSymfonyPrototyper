<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use CoreBundle\Business\Serializer\FSDSerializer;
use DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Business\Repository\AgentRepository;
use UserBundle\Business\Repository\GroupRepository;
use UserBundle\Entity\Agent;

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

    /**
     * @param AgentRepository $repository
     * @param GroupManager    $groupManager
     */
    public function __construct(AgentRepository $repository, GroupManager $groupManager)
    {
        $this->repository = $repository;
        $this->groupManager = $groupManager;
    }

    public function getGroupById($id)
    {
        return $this->groupManager->getGroupById($id);
    }

    /**
     * @param Agent $agent
     * @return Agent
     */
    public function save(Agent $agent)
    {
        return $this->repository->saveAgent($agent);
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
     * @return mixed
     */
    public function edit(Agent $agent)
    {
        return $this->repository->edit($agent);
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
        $data = json_decode($data)->data;
        /**
         * Retrieve agent from database by id
         * @var $dbAgent Agent
         */
        $dbAgent = $this->findAgentById($data->id);
        /**
         * Get agent attributes from request
         */
        $agentAttrs = $data->attributes;

        /**
         * Iterate through properties
         */
        foreach ($agentAttrs as $key => $value) {
            /**
             * Create function name
             */
            $func = 'set' . ucfirst($key);
            /**
             * Check if function is callable / if exists
             */
            if (is_callable(array($dbAgent, $func))) {
                switch ($key) {
                    case 'birthDate':
                        $dbAgent->$func(new DateTime($value));
                        break;
                    case 'plainPassword':
                        break;
                    case 'password':
                        break;
                    default:
                        $dbAgent->$func($value);
                        break;
                }
                /**
                 * Call function with param
                 */

            }
        }

        /**
         * Get address attributes from request
         */
        $addressAttrs = $data->relationships->address->data->attributes;
        /**
         * Iterate through properties
         */
        foreach ($addressAttrs as $key => $value) {
            /**
             * Create function name
             */
            $func = 'set' . ucfirst($this->dashesToCamelCase($key));
            /**
             * Check if function is callable / if exists
             */
            if (is_callable(array($dbAgent->getAddress(), $func))) {
                /**
                 * Call function with param
                 */
                $dbAgent->getAddress()->$func($value);
            }
        }

        /**
         * Get group id
         */
        $groupId = $data->relationships->group->data->id;

        /**
         * If agent group has changed
         */
        if ($dbAgent->getGroup()->getId() != $groupId) {
            /**
             *  Get group from database
             */
            $group = $this->getGroupById($groupId);
            /**
             * Set group to agent
             */
            $dbAgent->setGroup($group);
        }

        /**
         * Find superior agent from Database
         */
        $superiorId = $data->relationships->superior->data->id;

        if ($dbAgent->getSuperior()->getId() != $superiorId) {
            /**
             * Get superior from database
             */
            $superior = $this->findAgentById($superiorId);
            /**
             * Set superior agent
             */
            $dbAgent->setSuperior($superior);
        }

        /**
         * Edit agent
         */
        return $agent = $this->edit($dbAgent);
    }

        /**
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
    }