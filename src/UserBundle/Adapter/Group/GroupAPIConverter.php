<?php

namespace UserBundle\Adapter\Group;

use CoreBundle\Adapter\JsonAPIConverter;
use CoreBundle\Business\Serializer\FSDSerializer;
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
        $serializedObj = FSDSerializer::serialize($this->groupConvert());

        $this->request->attributes->set($this->param, new ArrayCollection(array($serializedObj)));
    }

    /**
     * @return mixed
     */
    public function groupConvert()
    {
        switch ($this->request->getMethod()) {
            case 'GET':
                if($this->request->get('filters')){
                    return $this->manager->jqgridAction($this->request);
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