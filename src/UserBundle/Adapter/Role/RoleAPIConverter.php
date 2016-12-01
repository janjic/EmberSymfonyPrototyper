<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\JsonAPIConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;

/**
 * Class RoleAPIConverter
 * @package UserBundle\Adapter\Role
 */
class RoleAPIConverter extends JsonAPIConverter
{
    /**
     * @param RoleManager $manager
     * @param Request     $request
     * @param string      $param
     */
    public function __construct(RoleManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        if ($resultConvert = parent::convert()) {
            if ($this->request->getMethod() == "DELETE") {
                $this->request->attributes->set($this->param, new ArrayCollection(array(null, 204)));
            } else {
                $this->request->attributes->set($this->param, new ArrayCollection(array($this->manager->serializeRole($resultConvert))));
            }
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array(json_encode(array('message' => 'Error!')), 410)));
        }
    }
}