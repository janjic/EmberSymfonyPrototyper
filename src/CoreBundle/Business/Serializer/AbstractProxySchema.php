<?php

namespace CoreBundle\Business\Serializer;

use Doctrine\Common\Util\Debug;
use Neomerx\JsonApi\Contracts\Schema\SchemaFactoryInterface;
use Neomerx\JsonApi\Schema\SchemaProvider;

class AbstractProxySchema extends SchemaProvider
{
    protected $resourceType = 'proxy';

    public function getId($entity)
    {
        return $entity->getId();
    }

    /**
     * Get resource attributes.
     *
     * @param object $resource
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [];
    }
}