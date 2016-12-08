<?php

namespace UserBundle\Business\Util;
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
        'agent'    => array('class' => Agent::class, 'type'=>'agents'),
        'group'    => array('class' => Group::class,  'type'=>'groups'),
        'superior' => array('class' => Agent::class,  'type'=>'agents'),
        'roles'    => array('class' => Role::class,   'type'=>'roles'),
        'image'    => array('class' => Image::class,  'type'=>'images'),
        'address'  => array('class' => Address::class, 'type'=>'address')
    );

    public static $relations = array('group', 'superior', 'group.roles', 'image', 'address');

}