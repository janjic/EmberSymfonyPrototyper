<?php

namespace UserBundle\Adapter\Agent;

use CoreBundle\Adapter\JsonAPIConverter;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AgentManager;

/**
 * Class AgentAPIConverter
 * @package UserBundle\Adapter\Agent
 *
 */
class AgentAPIConverter extends JsonAPIConverter
{
    /**
     * @param AgentManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(AgentManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, $this::convertAgent());
    }

    /**
     * @return mixed
     */
    public function convertAgent()
    {
        switch ($this->request->getMethod()) {
            case 'GET':
                if($this->request->get('page') && $this->request->get('offset')){
                    return $this->manager->jqgridAction($this->request);
                } else if($this->request->get('superAdmin')){
                    return $this->manager->findSerializedSuperAgent();
                } else if ($this->request->getQueryString()) {
                    return $this->manager->getQueryResult($this->request);
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