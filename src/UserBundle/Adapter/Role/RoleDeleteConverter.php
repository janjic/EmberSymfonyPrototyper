<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;

/**
 * Class RoleDeleteConverter
 * @package UserBundle\Adapter\Role
 */
class RoleDeleteConverter extends JQGridConverter
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
     * @return mixed
     */
    public function convert()
    {
        $id = intval($this->request->get('id'));

        if ($this->manager->removeNestedFromTree($id)) {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'role' => array(
                    'id' => $id
                ),
                'meta' => array(
                    'code' => 200,
                    'message' => 'Role deleted!'
                )
            )));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array('meta' => array('code' => 403, 'message' => 'Role not deleted!'))));
        }
    }
}