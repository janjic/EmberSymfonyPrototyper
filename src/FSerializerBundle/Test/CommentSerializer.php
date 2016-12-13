<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiRelationship;
use FSerializerBundle\Serializer\JsonApiOne;
use FSerializerBundle\Serializer\JsonApiSerializerAbstract;

class CommentSerializer extends JsonApiSerializerAbstract
{
    protected $type = 'comments';

    /**
     * @param Comment $comment
     * @param array|null $fields
     * @return array
     */
    public function getAttributes($comment, array $fields = null)
    {
        return ['body' => $comment->body];
    }

    public function author($comment)
    {
        return new JsonApiRelationship(new JsonApiOne($comment->author, new AuthorSerializer()));
    }

}