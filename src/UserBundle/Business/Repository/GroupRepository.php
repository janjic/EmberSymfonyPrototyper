<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\Group;

/**
 * Class GroupRepository
 * @package UserBundle\Business\Repository
 */
class GroupRepository extends EntityRepository
{
    const ALIAS       = 'groups';
    const ROLES_ALIAS = 'roles';

    const GROUP_USER_TABLE_NAME         = 'as_agent';
    const GROUP_USER_TABLE_GROUP_COLUMN = 'group_id';

    /**
     * @param $id
     * @return mixed
     */
    public function findGroup($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS, self::ROLES_ALIAS);
        $qb->leftJoin(self::ALIAS.'.roles', self::ROLES_ALIAS);

        if (intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')
                ->setParameter('id', $id);

            return $qb->getQuery()->getOneOrNullResult();
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Save new group
     * @param Group $group
     * @return mixed
     */
    public function saveGroup($group)
    {
        try {
            $this->_em->persist($group);
            $this->_em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return $group;
    }

    /**
     * @param Group $group
     * @return mixed
     */
    public function editGroup($group)
    {
        try {
            $this->_em->merge($group);
            $this->_em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return $group;
    }

    /**
     * @param int $oldGroupId
     * @param int $newGroupId
     * @return boolean
     */
    public function changeUsersGroup($oldGroupId, $newGroupId)
    {
        try {
            $sql = 'UPDATE '.self::GROUP_USER_TABLE_NAME.
                ' SET '.self::GROUP_USER_TABLE_GROUP_COLUMN .'='.$newGroupId.
                ' WHERE '.self::GROUP_USER_TABLE_GROUP_COLUMN .'='.$oldGroupId;

            $stmt = $this->_em->getConnection()->prepare($sql);
            $stmt->execute();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Remove group
     * @param Group $group
     * @return mixed
     */
    public function removeGroup($group)
    {
        try {
            $this->_em->remove($group);
            $this->_em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $id
     * @param $class
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     */
    public function createReference($id, $class)
    {
        return $this->_em->getReference($class, $id);
    }
}