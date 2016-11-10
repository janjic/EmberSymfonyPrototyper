<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;
use UserBundle\Entity\Role;

/**
 * Class RoleAddConverter
 * @package UserBundle\Adapter\Role
 */
class RoleAddConverter extends JQGridConverter
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
        $content = json_decode($this->request->getContent());

        /** @var Role $role */
        $role = $this->manager->addRole($content->role);
        if ($role) {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'role' => array(
                    'id' => $role->getId(),
                ),
                'meta' => array(
                    'code' => 200,
                    'message' => 'Role saved!'
                )
            )));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array('meta' => array('code' => 410, 'message' => 'Role not saved!'))));
        }
    }
}