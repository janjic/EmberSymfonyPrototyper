<?php

namespace FSerializerBundle\Test;

class Comment extends \stdClass
{
    /**
     * @param $commentId
     * @param $body
     * @param Author $author
     * @return Comment
     */
    public static function instance($commentId, $body, Author $author)
    {
        $comment = new self();
        $comment->id = $commentId;
        $comment->body      = $body;
        $comment->author    = $author;
        return $comment;
    }
}