<?php

namespace CoreBundle\Business\Manager;

/**
 * Class BasicEntityManagerTrait
 * @package CoreBundle\Business\Manager
 */
trait BasicEntityManagerTrait
{
    /**
     * @param $id
     * @return mixed
     */
    public function getEntityReference($id)
    {
        return $this->repository->getEntityReference($id);
    }


}