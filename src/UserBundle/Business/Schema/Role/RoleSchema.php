<?php

namespace UserBundle\Business\Schema\Role;

use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Role;

class RoleSchema extends SchemaProvider
{
    protected $resourceType = 'roles';

    /**
     * @param Role $entity
     * @return mixed
     */
    public function getId($entity)
    {
        return $entity->getId();
    }

    /**
     * @param Role $entity
     * @return array
     */
    public function getAttributes($entity)
    {
        return [
            'name' => $entity->getName()
        ];
    }
}