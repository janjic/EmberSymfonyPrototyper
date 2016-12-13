<?php

namespace CoreBundle\Adapter;
use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BasicConverter
 *
 * @package Alligator\Adapter
 */
class JsonAPIConverter extends BasicConverter
{

    /**
     * @return mixed
     */
    public function convert()
    {
        switch ($this->request->getMethod()) {
            case 'GET':
                if($this->request->get('page') && $this->request->get('offset')){
                    return $this->manager->jqgridAction($this->request);
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
                return $this->manager->deleteResource($this->request->get('id'));
            default:
                return null;
        }
    }
}