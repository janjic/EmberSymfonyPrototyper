<?php

namespace UserBundle\Adapter\Group;

use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\GroupManager;

/**
 * Class GroupAPIConverter
 * @package UserBundle\Adapter\Group
 */
class GroupAPIConverter extends JsonAPIConverter
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
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, new ArrayCollection($this->ticketConvert()));
    }

    /**
     * @return mixed
     */
    public function ticketConvert()
    {
        switch ($this->request->getMethod()) {
            case 'GET':
                if($this->request->get('filters')){
                    return $this->manager->jqgridAction($this->request);
                } else if( $this->request->get('group_name')){
                    return $this->manager->getGroupByName($this->request->get('group_name'));
                } else {
                    return $this->manager->getResource($this->request->get('id'));
                }
            case 'POST':
                return $this->manager->saveResource($this->request->getContent());
            case 'PUT':
                return $this->manager->updateResource($this->request->getContent());
            case 'PATCH':
                return $this->manager->updateResource($this->request->getContent());
            case 'DELETE':
                return $this->manager->deleteResource($this->request->getContent());
            default:
                return null;
        }
    }
}