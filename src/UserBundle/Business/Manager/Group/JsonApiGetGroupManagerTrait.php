<?php

namespace UserBundle\Business\Manager\Group;

/**
 * Class JsonApiGetGroupManagerTrait
 * @package UserBundle\Business\Manager\Group
 */
trait JsonApiGetGroupManagerTrait
{
    /**
     * @param null $id
     * @return mixed
     */
    public function getResource($id = null)
    {
        return $this->serializeGroup($this->repository->findGroup($id));
    }
}