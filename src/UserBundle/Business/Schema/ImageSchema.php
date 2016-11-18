<?php

namespace UserBundle\Business\Schema;

use Doctrine\Common\Util\Debug;
use Neomerx\JsonApi\Contracts\Schema\SchemaFactoryInterface;
use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Document\Image;

class ImageSchema extends SchemaProvider
{
    protected $resourceType = 'image';

    public function getId($entity)
    {
        return $entity->getId();
    }

    /**
     * @param Image $resource
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'file_path' => $resource->getFilePath(),
            'web_path'  => $resource->getWebPath(),
            'name'      => $resource->getName(),
        ];
    }
}