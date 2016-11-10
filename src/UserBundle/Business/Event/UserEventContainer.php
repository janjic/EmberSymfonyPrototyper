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


    /**
     * @return mixed
     */
    public function getSearchParam()
    {
        return $this->container->get('request_stack')->getCurrentRequest()->query->get('search');
    }

}