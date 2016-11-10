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
        $id = $this->request->get('id');
        $content = json_decode($this->request->getContent());

        $group = $this->manager->deleteGroup($id, $content->newParent);
        if ($group) {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'role' => array(
                    'id' => $id
                ),
                'meta' => array(
                    'code' => 200,
                    'message' => 'Group deleted!'
                )
            )));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array('meta' => array('code' => 403, 'message' => 'Group not deleted!'))));
        }
    }
}