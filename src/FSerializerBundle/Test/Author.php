<?php
namespace FSerializerBundle\Test;

class Author extends \stdClass
{
    /**
     * @param string $authorId
     * @param string $firstName
     * @param string $lastName
     *
     * @return Author
     */
    public static function instance($authorId, $firstName, $lastName)
    {
        $author = new self();
        $author->id  = $authorId;
        $author->firstName = $firstName;
        $author->lastName  = $lastName;
        return $author;
    }
}