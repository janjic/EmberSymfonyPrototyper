<?php

namespace UserBundle\Business\Schema\Group;

use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Group;

class GroupSchema extends SchemaProvider
{
    protected $resourceType = 'groups';

    /**
     * @param Group $entity
     * @return mixed
     */
    public function getId($entity)
    {
        return $entity->getId();
    }

    /**
     * @param Group $entity
     * @return array
     */
    public function getAttributes($entity)
    {
        return [
            'name' => $entity->getName()
        ];
    }

    /**
     * @param Group $group
     * @param bool $isPrimary
     * @param array $includeList
     * @return array
     */
    public function getRelationships($group, $isPrimary, array $includeList)
    {
        return [
            'roles' => [self::DATA => $group->getRolesCollection()]
        ];
    }

    public function getIncludePaths() {
        return ['roles'];
    }

}