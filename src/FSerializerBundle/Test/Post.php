<?php

namespace FSerializerBundle\Test;

class Post extends \stdClass
{
    /**
     * @param $postId
     * @param $title
     * @param $body
     * @param Author $author
     * @param array $comments
     * @return Post
     */
    public static function instance($postId, $title, $body, Author $author, array $comments)
    {
        $post = new self();
        $post->id   = $postId;
        $post->title    = $title;
        $post->body     = $body;
        $post->author   = $author;
        $post->comments = $comments;
        return $post;
    }
}