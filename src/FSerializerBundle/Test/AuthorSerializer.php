<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiMany;
use FSerializerBundle\Serializer\JsonApiRelationship;
use FSerializerBundle\Serializer\JsonApiSerializerAbstract;

class AuthorSerializer extends JsonApiSerializerAbstract
{
    protected $type = 'authors';

    /**
     * @param mixed $author
     * @param array|null $fields
     * @return array
     */
    public function getAttributes($author, array $fields = null)
    {
        return [
            'firstName' => $author->firstName,
            'lastName'  => $author->lastName
        ];
    }
}