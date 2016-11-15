<?php

namespace UserBundle\Business\Schema\Group;

use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Group;

class GroupSchema extends SchemaProvider
{
    protected $resourceType = 'group';

    public function getId($author)
    {
        /** @var Group $author */
        return $author->getId();
    }

    public function getAttributes($author)
    {
        /** @var Group $author */
        return [
            'name' => $author->getName()
        ];
    }

    public function getRelationships($group, $isPrimary, array $includeList)
    {
        /** @var Group $group */
        return [
            'roles'   => [self::DATA => $group->getRolesCollection()]
        ];
    }

    public function getIncludePaths(){
        return ['roles'];
    }

}