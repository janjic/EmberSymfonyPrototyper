<?php

namespace CoreBundle\Adapter;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class BaseAdapterUtil
 * @package Alligator\Adapter
 */
abstract class BaseAdapterUtil
{
    /**
     * Gets an array of the possible values.
     *
     * @return array
     */
    protected static function getPossibleValues()
    {

        return (new \ReflectionClass(get_called_class()))->getConstants();
    }

    /**
     * @param string $param
     *
     * @return bool
     */
    public static function isAcceptable($param)
    {
        return in_array($param, self::getPossibleValues());

    }





}