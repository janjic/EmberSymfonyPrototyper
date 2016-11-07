<?php

namespace CoreBundle\Adapter;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BaseAdapter
 * @package Alligator\Adapter
 */
abstract class BaseAdapter implements ParamConverterInterface, AdapterInterface
{
    /**
     * Stores the object in the request.
     *
     * @param Request        $request       The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool    True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $this->convert($this->buildConverterInstance($configuration->getName(), $request));

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool    True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        $class = $this->getAdapterUtil();

        return $class::isAcceptable($configuration->getName());
    }

    /**
     * @param BasicConverter $converter
     *
     * @return mixed
     */
    public function convert(BasicConverter $converter)
    {
        $converter->convert();
    }

    /**
     * @return string
     */
    public function getNameSpace()
    {
        return substr(get_called_class(), 0, strrpos(get_called_class(), '\\'));
    }

    /**
     * @return string
     */
    public function getAdapterUtil()
    {
        return get_called_class().'Util';
    }

    /**
     * @param string  $param
     * @param Request $request
     *
     * @return BasicConverter
     */
    abstract public function buildConverterInstance($param, Request $request);
}