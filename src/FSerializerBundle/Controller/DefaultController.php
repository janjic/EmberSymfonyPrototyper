<?php

namespace FSerializerBundle\Controller;

use CoreBundle\Adapter\AgentApiCode;
use CoreBundle\Dumper\ApiCodeDumper;
use FSerializerBundle\Serializer\JsonApiDocument;
use FSerializerBundle\Serializer\JsonApiOne;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class DefaultController
 * @package FSerializerBundle\Controller
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        var_dump((new ApiCodeDumper($this->get('templating'), $this->get('filesystem')))->dump());
        exit;
        //Object from DB
        $agent = $this->get('agent_system.agent.manager')->getResource(42);
        var_dump($agent);exit;
        $relations = array('group', 'superior.*', 'group.roles', 'image', 'address');
        //LINKS AND META ARE OPTIONALS
        $mappings =
            array(
                'agent' => array('class' => Agent::class, 'type'=>'agents',
                    'links'=> array('function'=>function($routing, $resource=null)
                    {
                        return ['self' => $routing->generate('api_agents', array('id'=> $resource->getId())), 'next' => 'asdsadasdsa'];

                    }, 'dependency'=>array($this->get('router'))),
                    'meta'=> array('function'=>function($routing, $resource=null)
                    {
                        return ['meta_self' => $routing->generate('api_agents', array('id'=> $resource->getId())), 'meta_next' => 'asdsadasdsa'];

                    }, 'dependency'=>array($this->get('router')))),
                'group'    => array('class' => Group::class,  'type'=>'groups'),
                'superior' => array('class' => Agent::class,  'type'=>'agents'),
                'roles'    => array('class' => Role::class,   'type'=>'roles'),
                'image'    => array('class' => Image::class,  'type'=>'images'),
                'address'  => array('class' => Address::class, 'type'=>'address')
            );

        $serialized = $this->get('f_serializer')->serialize($agent, $mappings, $relations);

        //Adding links to main resource, OPTIONAL
        $serialized->addMeta('total',100);
        $serialized->addLink('self', $this->get('router')->generate('api_agents'));


        return new JsonResponse($serialized);
        //DESERIALIZATION
        $string = json_encode($serialized);

        $serializer = $this->get('f_serializer')->deserialize($string,$mappings, $relations);
        var_dump($serializer);
        exit;
//
        $resource = (new JsonApiOne(null, $serializer))->relations(array('group', 'superior.*', 'group.roles', 'image', 'address'));
        var_dump((new JsonApiDocument($resource))->deserialize($string));
        exit;



//        var_dump($this->get('f_serializer.default')->setMappings($mappings));
//        exit;

//        $agents = array();
//        for ($i=0; $i<3; $i++) {
//            array_push($agents, $agent);
//        }
//        $time_start = microtime(true);

        // $serializer = $this->get('f_serializer.default')->setMappings($mappings)->setIncludedAttributes(array('salt', 'accountNonExpired', 'accountNonLocked', 'credentialsNonExpired'));
        $resource = (new JsonApiOne($agent, $this->get('f_serializer.default')->setType('agents')->setMappings($mappings)->setDisabledAttributes($disabled)))->relations(array('group','group.roles', 'superior', 'image', 'address'));
        $document = new JsonApiDocument($resource);
        //return new JsonResponse($document);
        $string = json_encode($document);

        //Deserialization

        $resource = (new JsonApiOne(new Agent(), $this->get('f_serializer.default')->setType('agents')->setDeserializationClass(Agent::class)->setMappings($mappings)->setDisabledAttributes($disabled)))->relations(array('group','group.roles', 'superior', 'image', 'address'));

        var_dump((new JsonApiDocument($resource))->deserialize($decoded));
        exit;

        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo "Process Time: {$time}";
       exit;
        return new JsonResponse($document);


        $objCopy = $serializer->deserialize($string, Agent::class, 'json');
        var_dump($objCopy);
        exit;
//        var_dump($objCopy);
//        exit;
        return new JsonResponse($document);
    }


}
