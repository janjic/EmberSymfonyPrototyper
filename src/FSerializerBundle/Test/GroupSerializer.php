<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiMany;
use FSerializerBundle\Serializer\JsonApiRelationship;
use FSerializerBundle\Serializer\JsonApiSerializerAbstract;
use UserBundle\Entity\Group;

class GroupSerializer extends JsonApiSerializerAbstract
{
    protected $type = 'groups';

    /**
     * @param Group $group
     * @param array|null $fields
     * @return array
     */
    public function getAttributes($group, array $fields = null)
    {
          return [
            'name' => $group?$group->getName():null
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId($model)
    {
        return $model->getId();
    }

    /**
     * @param Group $group
     * @return JsonApiRelationship
     */
    public function roles($group)
    {
        return new JsonApiRelationship(new JsonApiMany($group->getRoles(), new RoleSerializer()));
    }

    public function getDeserializationClass()
    {
        return Group::class;
    }
}