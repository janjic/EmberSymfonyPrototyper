<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\JsonAPIConverter;
use CoreBundle\Business\Serializer\FSDSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;

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
        $serializedObj = FSDSerializer::serialize(parent::convert());

        $this->request->attributes->set($this->param, new ArrayCollection(array($serializedObj)));
    }
}