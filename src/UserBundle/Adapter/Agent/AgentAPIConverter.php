<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\JsonAPIConverter;
use CoreBundle\Business\Serializer\FSDSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Proxy;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;
use UserBundle\Business\Schema\Agent\AgentSchema;
use UserBundle\Business\Schema\Group\GroupSchema;

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
        $schemaMappings = FSDSerializer::$schemaMappings;
        $schemaMappings['Proxies\__CG__\UserBundle\Entity\Group'] = GroupSchema::class;
        $schemaMappings['Proxies\__CG__\UserBundle\Entity\Agent'] = AgentSchema::class;
        $serializedObj = FSDSerializer::serialize($agent, [], $schemaMappings);

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