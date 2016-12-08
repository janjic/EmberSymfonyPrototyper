<?php

namespace UserBundle\Business\Manager\Role;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class JsonApiGetRoleManagerTrait
 * @package UserBundle\Business\Manager\Role
 */
trait JsonApiGetRoleManagerTrait
{
    /**
     * @param null $id
     * @return array
     */
    public function getResource($id = null)
    {
        return $this->serializeRole($this->repository->findRole($id));
    }
}