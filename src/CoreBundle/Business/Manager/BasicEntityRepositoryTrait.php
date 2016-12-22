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

    /**
     * @param $id
     * @param $class
     * @return mixed
     */
    public function getReferenceForClass($id, $class)
    {
        return $this->_em->getReference($class, intval($id));
    }
}