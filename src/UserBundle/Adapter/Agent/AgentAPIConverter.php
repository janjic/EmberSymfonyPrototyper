<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\JsonAPIConverter;
use CoreBundle\Business\Serializer\FSDSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;

/**
 * Class AgentAPIConverter
 * @package UserBundle\Adapter\Agent
 *
 */
class AgentAPIConverter extends JsonAPIConverter
{
    /**
     * @param AgentManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(AgentManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {

        /**
         * If method is patch perform edit
         */
        if($this->request->isMethod('PATCH')){
            $data = json_decode($this->request->getContent())->data;

            /**
             * Retrieve agent from database by id
             * @var $dbAgent Agent
             */
            $dbAgent = $this->manager->findAgentById($data->id);

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
                $func = 'set'.ucfirst($key);
                /**
                 * Check if function is callable / if exists
                 */
                if(is_callable(array($dbAgent, $func))){
                    switch ($key){
                        case 'birthDate':
                            $dbAgent->$func(new DateTime($value));
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
                $func = 'set'.ucfirst($this->dashesToCamelCase($key));
                /**
                 * Check if function is callable / if exists
                 */
                if(is_callable(array($dbAgent->getAddress(), $func))){
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
            if($dbAgent->getGroup()->getId() != $groupId){
                /**
                 *  Get group from database
                 */
                $group = $this->manager->getGroupById($groupId);
                /**
                 * Set group to agent
                 */
                $dbAgent->setGroup($group);
            }

            /**
             * Edit agent
             */
            $agent = $this->manager->edit($dbAgent);

            /**
             *  Serialize agent object
             */
            $serializedObj = FSDSerializer::serialize($agent);
        } else {

            $id = $this->request->get('id');
            $agent = $this->manager->findAgentById($id);

            $serializedObj = FSDSerializer::serialize($agent);
        }

        $agent = parent::convert();

        $this->request->attributes->set($this->param, new ArrayCollection(array($serializedObj)));

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