<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;

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
//        $content = json_decode($this->request->getContent());
//        $groups = $this->manager->addGroup($content);
//        if ($groups) {
//            $this->request->attributes->set($this->param, new ArrayCollection(array('code' => 200, 'message' => 'Group saved!')));
//        } else {
//            $this->request->attributes->set($this->param, new ArrayCollection(array('code' => 403, 'message' => 'Group not saved!')));
//        }
    }
}