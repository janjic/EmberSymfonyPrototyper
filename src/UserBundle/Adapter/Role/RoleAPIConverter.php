<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\AgentApiResponse;
use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;
use UserBundle\Entity\Role;

/**
 * Class RoleAPIConverter
 * @package UserBundle\Adapter\Role
 */
class RoleAPIConverter extends JsonAPIConverter
{
    /**
     * @param RoleManager $manager
     * @param Request     $request
     * @param string      $param
     */
    public function __construct(RoleManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, new ArrayCollection(parent::convert()));
    }
}