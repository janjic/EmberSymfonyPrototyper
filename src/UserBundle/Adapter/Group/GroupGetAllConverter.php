<?php

namespace UserBundle\Adapter\Group;

use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\GroupManager;

/**
 * Class GroupGetAllConverter
 * @package UserBundle\Adapter\Group
 */
class GroupGetAllConverter extends JQGridConverter
{
    /**
     * @param GroupManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(GroupManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @return mixed
     */
    public function convert()
    {
        $groups = $this->manager->findAllGroups();

        $this->request->attributes->set($this->param, new ArrayCollection($groups));
    }
}