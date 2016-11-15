<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;

/**
 * Class RoleUpdateConverter
 * @package UserBundle\Adapter\Role
 */
class RoleUpdateConverter extends JQGridConverter
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
        $json = json_decode($this->request->getContent());
        $role = $json->role;

        $entity = $this->manager->changeNested($this->request->get('id'), $role);
        if ($entity) {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'meta' => array(
                    'code' => 200,
                    'message' => 'Role changed!'
                )
            )));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array('code' => 403, 'message' => 'Role not changed!')));
        }
    }
}