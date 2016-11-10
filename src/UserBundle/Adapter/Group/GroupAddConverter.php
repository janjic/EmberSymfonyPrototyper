<?php

namespace UserBundle\Adapter\Group;

use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\GroupManager;
use UserBundle\Entity\Group;

/**
 * Class GroupAddConverter
 * @package UserBundle\Adapter\Group
 */
class GroupAddConverter extends JQGridConverter
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
        $content = json_decode($this->request->getContent());
        /** @var Group $group */
        $group = $this->manager->addGroup($content);
        if ($group) {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'group' => array(
                    'id' => $group->getId(),
                ),
                'meta' => array(
                    'code' => 200,
                    'message' => 'Group saved!'
                )
            )));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array('meta' => array('code' => 403, 'message' => 'Group not saved!'))));
        }
    }
}