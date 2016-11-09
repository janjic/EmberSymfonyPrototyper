<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\EntityRepository;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use UserBundle\Entity\Role;

/**
 * Class RoleRepository
 * @package UserBundle\Business\Repository
 */
class RoleRepository extends NestedTreeRepository
{
    const ALIAS = 'roles';

    /**
     * @return array
     */
    public function getAll()
    {
        $qb = $this->getNodesHierarchyQueryBuilder();
//        $qb->leftJoin('node.parent', 'parent');
//        $qb->select('node', 'parent');
        $rows = $qb->getQuery()->getArrayResult();
        $rows ? $result = $this->buildTree($rows, array()) : $result = [];

        return $result;
    }
}