<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\JsonAPIConverter;
use CoreBundle\Business\Serializer\FSDSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Proxy;
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

        $agent = parent::convert();
//        $agent->__load();
//        var_dump($agent);exit;
//        $agent = ($agent instanceof Proxy)? $agent->__load():$agent;
//        var_dump($agent);exit;
//        var_dump($agent);exit;
        $serializedObj = FSDSerializer::serialize($agent);
//        var_dump($serializedObj);exit;
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