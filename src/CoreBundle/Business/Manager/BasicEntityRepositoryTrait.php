<?php

namespace CoreBundle\Business\Manager;

/**
 * Class BasicEntityRepositoryTrait
 * @package CoreBundle\Business\Manager
 */
trait BasicEntityRepositoryTrait
{
    /**
     * @param $id
     * @return mixed
     */
    public function getEntityReference($id)
    {
        return $this->_em->getReference($this->_entityName, intval($id));
    }


}