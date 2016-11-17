<?php

namespace CoreBundle\Adapter;
use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BasicConverter
 *
 * @package Alligator\Adapter
 */
abstract class BasicConverter
{
    protected $request;
    protected $manager;
    protected $param;

    /**
     * @param BasicEntityManagerInterface|JsonAPIConverter $manager
     * @param Request                     $request
     * @param string                      $param
     */
    public function __construct(BasicEntityManagerInterface $manager, Request $request, $param)
    {
        $this->manager = $manager;
        $this->request = $request;
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public abstract function convert();

}