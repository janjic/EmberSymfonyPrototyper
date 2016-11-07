<?php

namespace UserBundle\Business\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class UserEventContainer
 *
 * @package Alligator\Business\Event\User
 */
class UserEventContainer
{
    /**
     * @param ContainerInterface $container
     */
    public function  __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


}