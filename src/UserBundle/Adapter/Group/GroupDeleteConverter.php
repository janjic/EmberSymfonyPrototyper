<?php

namespace UserBundle\Adapter\Group;

use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\GroupManager;

/**
 * Class GroupDeleteConverter
 * @package UserBundle\Adapter\Group
 */
class GroupDeleteConverter extends JQGridConverter
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
        $groups = $this->manager->deleteGroup($this->request->get('id'), $this->request->get('parentId'));
        if ($groups) {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'code' => 200,
                "id" => $this->request->get('id'),
                "type"=> "success",
                'message' => 'Group deleted!'
            )));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array('code' => 403, 'message' => 'Group not deleted!')));
        }
    }
}