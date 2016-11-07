<?php

namespace CoreBundle\Adapter;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface AdapterInterface
 * @package CoreBundle\Adapter
 */
interface AdapterInterface
{
    /**
     * @param BasicConverter $converter
     *
     * @return mixed
     */
    public function convert(BasicConverter $converter);

    /**
     * @param string  $param
     * @param Request $request
     *
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request);

}