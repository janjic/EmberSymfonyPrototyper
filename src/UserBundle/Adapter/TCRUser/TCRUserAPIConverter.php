<?php

namespace UserBundle\Adapter\TCRUser;

use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\TCRUserManager;

/**
 * Class TCRUserAPIConverter
 * @package UserBundle\Adapter\TCRUser
 */
class TCRUserAPIConverter extends JsonAPIConverter
{
    /**
     * @param TCRUserManager $manager
     * @param Request        $request
     * @param string         $param
     */
    public function __construct(TCRUserManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        if ($resultConvert = $this->tcrUserConvert()) {
            $this->request->attributes->set($this->param, new ArrayCollection(is_array($resultConvert) ? $resultConvert : array($resultConvert)));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array(json_encode(array('message' => 'Error in CR sync!')), 410)));
        }
    }

    /**
     * @return mixed
     */
    public function tcrUserConvert()
    {
        switch ($this->request->getMethod()) {
            case 'GET':
                if($this->request->get('offset') && $this->request->get('page')){
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
                return $this->manager->deleteResource($this->request->get('id'));
            default:
                return null;
        }
    }
}