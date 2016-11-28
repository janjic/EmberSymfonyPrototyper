<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiMenu;
use FSerializerBundle\Serializer\JsonApiRelationship;
use FSerializerBundle\Serializer\JsonApiOne;
use FSerializerBundle\Serializer\JsonApiSerializerAbstract;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

class RoleSerializer extends JsonApiSerializerAbstract
{
    protected $type = 'roles';

    /**
     * @param Role $role
     * @param array|null $fields
     * @return array
     */
    public function getAttributes($role, array $fields = null)
    {
          return [
              'name' => $role?$role->getName():null,
              'role' =>$role?$role->getRole():null,
          ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId($model)
    {
        return $model->getId();
    }


    public function getDeserializationClass()
    {
        return Role::class;
    }
}