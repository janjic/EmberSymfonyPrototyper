<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\EntityRepository;
use Exception;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use UserBundle\Entity\Role;

/**
 * Class RoleRepository
 * @package UserBundle\Business\Repository
 */
class RoleRepository extends NestedTreeRepository
{
    const ALIAS        = 'roles';
    const PARENT_ALIAS = 'parent';

    /**
     * @param $id
     * @return array|Role|null
     */
    public function findRole($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS, self::PARENT_ALIAS);
        $qb->leftJoin(self::ALIAS.'.parent', self::PARENT_ALIAS);

        if(intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')->setParameter('id', $id);

            return $qb->getQuery()->getOneOrNullResult();
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Role $role
     * @return Role|Exception
     */
    public function saveItem(Role $role)
    {
        try {
            $this->persistAsFirstChild($role);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $role;
    }

    /**
     * @param Role $role
     * @return Role|Exception
     */
    public function simpleUpdate(Role $role)
    {
        try {
            $this->_em->merge($role);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $role;
    }

    /**
     * @param $id
     * @return boolean|Exception
     */
    public function removeNestedFromTree($id)
    {
        $className = $this->getClassMetadata()->getReflectionClass()->getName();
        try {
            $this->_em->remove($this->_em->getReference($className, $id));
            $this->_em->flush();
            $this->_em->clear();
        } catch (Exception $e) {
            return $e;
        }

        return true;
    }



    /**
     * @param int $id
     * @param int $prev
     * @param int $parent
     * @return Role|Exception
     */
    public function changeNested($id, $prev, $parent)
    {
        /** @var Role $entity */
        $entity = $this->findRole($id);

        try {
            $className = $this->getClassMetadata()->getReflectionClass()->getName();

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
        } catch (Exception $e) {
            return $e;
        }

        return $entity;
    }

}