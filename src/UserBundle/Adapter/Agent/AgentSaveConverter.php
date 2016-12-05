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
         * @var Agent $agent
         */
        $agent = $this->manager->deserializeAgent($this->request->getContent());

        $agent->setUsername($agent->getEmail());
        $agent->setBirthDate(new DateTime($agent->getBirthDate()));


        if(!is_null($agent->getImage()) && $agent->getImage()->getId() ==0 && $agent->getImage()->getBase64Content() != null){
            $image = new Image();
            $image->setBase64Content($agent->getImage()->getBase64Content());
            $image->setName($agent->getImage()->getName());
            $image->saveToFile($image->getBase64Content());

            $agent->setImage($image);
            $agent->setBaseImageUrl($image->getWebPath());
        } else {
            $agent->setImage(null);
        }

        $group = $this->manager->getGroupById($agent->getGroup()->getId());


        /**
         * If agent is not root set his superior agent
         */
        $superior = null;

        if(!is_null($agent->getSuperior())) {
            $superior = $this->manager->findAgentById($agent->getSuperior()->getId());
        }

        /**
         * Populate agent object with relationships and image url
         */
//        $agent->setAddress($address);
        $agent->setGroup($group);

        /**
         * @var $agent Agent
         */
        $agent = $this->manager->save($agent, $superior);

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