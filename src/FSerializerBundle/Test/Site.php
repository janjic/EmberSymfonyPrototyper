<?php

namespace FSerializerBundle\Test;
/**
 * Class Site
 */
class Site extends \stdClass
{
    /**
     * @param $siteId
     * @param $name
     * @param array $posts
     * @return Site
     */
    public static function instance($siteId, $name, array $posts)
    {
        $site = new self();
        $site->id = $siteId;
        $site->name   = $name;
        $site->posts  = $posts;
        return $site;
    }
}