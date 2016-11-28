<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiMany;
use FSerializerBundle\Serializer\JsonApiRelationship;
use FSerializerBundle\Serializer\JsonApiSerializerAbstract;

class PostSerializer extends JsonApiSerializerAbstract
{
    protected $type = 'posts';

    /**
     * @param mixed $post
     * @param array|null $fields
     * @return array
     */
    public function getAttributes($post, array $fields = null)
    {
        return [
            'title' => $post->title,
            'body'  => $post->body
        ];
    }

    public function comments($post)
    {
        return new JsonApiRelationship(new JsonApiMany($post->comments, new CommentSerializer()));
    }

    public function getDeserializationClass()
    {
        // TODO: Implement getDeserializationClass() method.
    }
}