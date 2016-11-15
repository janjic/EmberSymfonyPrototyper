<?php

namespace UserBundle\Business\Schema\Role;

use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Group;

class RoleSchema extends SchemaProvider
{
    protected $resourceType = 'roles';

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
}