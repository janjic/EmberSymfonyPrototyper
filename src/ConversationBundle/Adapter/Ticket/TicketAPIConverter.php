<?php

namespace ConversationBundle\Adapter\Ticket;

use ConversationBundle\Business\Manager\TicketManager;
use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TicketAPIConverter
 * @package UserBundle\Adapter\Group
 */
class TicketAPIConverter extends JsonAPIConverter
{
    /**
     * @param TicketManager $manager
     * @param Request       $request
     * @param string        $param
     */
    public function __construct(TicketManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, new ArrayCollection($this->groupConvert()));
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