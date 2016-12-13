<?php

namespace UserBundle\Business\Manager\Role;

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