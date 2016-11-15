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
        $qb->leftJoin('node.parent', 'parent');
        $qb->select('node', 'parent');
        $rows = $qb->getQuery()->getArrayResult();
        $rows ? $result = $this->buildTree($rows, array()) : $result = [];

        foreach ($rows as &$row) {
            if ($row['parent']) {
                $row['parent']['type'] = 'role';
            }
        }
        return $rows;
    }

    /**
     * @param Role $menuItem
     * @return mixed
     */
    public function saveItem(Role $menuItem)
    {
        try {
            $this->persistAsFirstChild($menuItem);
            $this->_em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return $menuItem;
    }

    /**
     * @param int $id
     * @param int $prev
     * @param int $parent
     * @param string $name
     * @param string $role
     * @return mixed
     */
    public function changeNested($id, $prev, $parent, $name, $role)
    {
        try {
            $className = $this->getClassMetadata()->getReflectionClass()->getName();

            /** @var Role $entity */
            $entity = $this->_em->getReference($className, $id);
            $entity->setName($name);
            $entity->setRole($role);

            $prev = $prev ? $this->_em->getReference($className, $prev) : $prev;
            $parent = $parent ? $this->_em->getReference($className, $parent) : null;

            if ($prev) {
                try {
                    $this->persistAsNextSiblingOf($entity, $prev);
                } catch (\Exception $e) {
                    /** set it as root */
                    $entity->setParent(null);
                    $this->persistAsFirstChild($entity);
                }
            } else if ($parent) {
                $this->persistAsFirstChildOf($entity, $parent);
            } else {
                /** set it as root */
                $entity->setParent(null);
                $this->persistAsFirstChild($entity);
            }

            $this->_em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param Role $role
     * @return bool
     */
    public function simpleUpdate(Role $role)
    {
        try {
            $this->_em->merge($role);
            $this->_em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $id
     * @return boolean
     */
    public function removeNestedFromTree($id)
    {
        $className = $this->getClassMetadata()->getReflectionClass()->getName();
        try {
            $this->_em->remove($this->_em->getReference($className, $id));
            $this->_em->flush();
            $this->_em->clear();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}