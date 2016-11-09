<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;

/**
 * Class RoleGetAllConverter
 * @package UserBundle\Adapter\Role
 */
class RoleGetAllConverter extends JQGridConverter
{
    /**
     * @param RoleManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(RoleManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @return mixed
     */
    public function convert()
    {
        $roles = $this->manager->getAll();

        if ($roles) {
            $this->request->attributes->set($this->param, new ArrayCollection($roles));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array('code' => 201, 'message' => 'Roles not available!')));
        }
    }
}