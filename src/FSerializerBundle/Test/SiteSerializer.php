<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiMenu;
use FSerializerBundle\Serializer\JsonApiRelationship;
use FSerializerBundle\Serializer\JsonApiSerializerAbstract;

class SiteSerializer extends JsonApiSerializerAbstract
{
    protected $type = 'sites';

    /**
     * @param mixed $site
     * @param array|null $fields
     * @return array$site
     */
    public function getAttributes($site, array $fields = null)
    {
        return [
            'name' => $site->name,
        ];
    }

    public function posts($site)
    {
        return new JsonApiRelationship(new JsonApiMenu($site->posts, new PostSerializer()));
    }
}