<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\JQGridConverter;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Business\Manager\GroupManager;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;

/**
 * Class AgentSaveConverter
 * @package UserBundle\Adapter\Agent
 */
class AgentSaveConverter extends JQGridConverter
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
         * Get get data from request and decode it
         */
        $content = json_decode($this->request->getContent())->data;

        /**
         * Get attributes for agent object
         */
        $agentAttr = $content->attributes;

        /**
         * Create new agent object
         */
        $agent = new Agent();

        /**
         * Iterate through attributes and call set method on agent object to populate it
         * If key is birthDate create new DateTime object from string date
         */
        foreach ($agentAttr as $key => $value) {

            /**
             * Create function name
             */
            $func = 'set'.ucfirst($key);
            /**
             * Check if function is callable / if exists
             */
            if(is_callable(array($agent, $func))&& !is_null($value)){
                switch ($key){
                    case 'birthDate':
                        $agent->$func(new DateTime($value));
                        break;
                    case 'email':
                        $agent->$func($value);
                        $agent->setUsername($value);
                        break;
                    default:
                        $agent->$func($value);
                        break;
                }
            }
        }

        /**
         * Get data for address
         */
        $addressAttr = $content->relationships->address->data->attributes;

        /**
         * Create new address object
         */
        $address = new Address();

        /**
         * Iterate through attributes and call set method on address object to populate it
         */
        foreach ($addressAttr as $key => $value) {
            /**
             * Create function name
             * dashesToCamelCase - create camelCase format from underscore
             */
            $func = 'set'.ucfirst($this->dashesToCamelCase($key));
            /**
             * Check if function is callable / if exists
             */
            if(is_callable(array($address, $func))){
                /**
                 * Call function with param
                 */
                $address->$func($value);
            }
        }

        /**
         * Get data for image
         */
        $imageAttr = $content->relationships->image->data->attributes;

        /**
         * If image is defined
         */
        if(property_exists($imageAttr, 'base64_content')){
            /**
             * Create image object
             */
            $image = new Image();

            /**
             * Populate image object
             */
            $image->setBase64Content($imageAttr->base64_content);
            $image->setName($imageAttr->name);

            /**
             * Save image to file
             */
            $image->saveToFile($image->getBase64Content());

            $agent->setImage($image);
            $agent->setBaseImageUrl($image->getWebPath());
        }

        /**
         * Get group from database by id
         */
        $group = $this->manager->getGroupById($content->relationships->group->data->id);

        /**
         * Find superior agent from Database
         */
        $superiorAttrs = $content->relationships->superior->data;

        /**
         * If agent is not root set his superior agent
         */
        if(!is_null($superiorAttrs)) {
            $superior = $this->manager->findAgentById($superiorAttrs->id);
            $agent->setSuperior($superior);
        }

        /**
         * Populate agent object with relationships and image url
         */
        $agent->setAddress($address);
        $agent->setGroup($group);

        /**
         * @var $agent Agent
         */
        $agent = $this->manager->save($agent);

        if($agent->getId()){
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'data' => array('type'=> 'agents', 'id' => $agent->getId()),
                'meta' => array('code'=> 200, 'message' => 'Agent successfully saved'))));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'user' => array('id' => null),
                'meta' => array('code'=> 500, 'message' => 'Agent not saved'))));
        }
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