<?php

namespace CoreBundle\Adapter;


/**
 * Interface JQGridInterface
 * @package CoreBundle\Adapter
 */
interface JQGridInterface
{
    /**
     * @param array $searchParams
     * @param array $sortParams
     * @param array $additionalParams
     * @return mixed
     */
    public function searchForJQGRID($searchParams, $sortParams = array(), $additionalParams = array());

    /**
     * @param int   $page
     * @param int   $offset
     * @param array $sortParams
     * @param array $additionalParams
     * @return mixed
     */
    public  function  findAllForJQGRID($page, $offset, $sortParams, $additionalParams = array());

    /**
     * @param null  $searchParams
     * @param null  $sortParams
     * @param array $additionalParams
     * @return mixed
     */
    public function  getCountForJQGRID($searchParams = null, $sortParams = null,  $additionalParams = array());


}