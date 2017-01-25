<?php

namespace UserBundle\Business\Util;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class AgentSerializerInfo
 */
class AgentSerializerInfo
{

    public static $mappings = array(
        'agent'    => array('class' => Agent::class,  'type'=>'agents'),
        'group'    => array('class' => Group::class,  'type'=>'groups'),
        'superior' => array('class' => Agent::class,  'type'=>'agents'),
        'roles'    => array('class' => Role::class,   'type'=>'roles'),
        'image'    => array('class' => Image::class,  'type'=>'images'),
        'address'  => array('class' => Address::class, 'type'=>'address')
    );

    public static $disabledAttributes = array('lft', 'lvl','rgt','root');
    public static $onAgentEditDisabledAttributes = array('baseImageUrl',);

    public static $relations = array('group', 'superior', 'group.roles', 'image', 'address');

    public static $basicFields = array(
        'agents'=>
            array('title', 'agentId', 'firstName', 'lastName', 'privateEmail', 'email','socialSecurityNumber', 'nationality',
                  'birthDate', 'bankName', 'bankAccountNumber', 'agentBackground', 'roles', 'id', 'username', 'enabled', 'socialSecurityNumber', 'notifications', 'baseImageUrl'),
        'images'=> array('fileSize', 'name', 'webPath', 'base64Content')
        );


    public static function updateBasicFields ($agent, $dbAgent, $fields=array())
    {
        if (!$fields) {
            $fields = array_diff(self::$basicFields['agents'], ["username", "id", 'email']);
        }
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($fields as $field) {
            try {
                $propertyAccessor->setValue($dbAgent, $field, $propertyAccessor->getValue($agent, $field));
            } catch (Exception $exception) {
                throw  $exception;
                //TODO
            }
        }

    }

}