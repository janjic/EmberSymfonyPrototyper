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
    const ALIAS = 'groups';
    const USERS_GROUP = 'users';
    const COMPANY_GROUP = 'users';
    const GROUP_USER_TABLE_NAME         = 'as_group_user';
    const GROUP_USER_TABLE_GROUP_COLUMN = 'group_id';

    /**
     * Get all groups
     * @return array
     */
    public function findAllGroups()
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS.'.id', self::ALIAS.'.name');

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
            throw $e;
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
     * @return boolean
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

//    /**
//     * Utility override to be used by the UserManager
//     *
//     * {@inheritDoc}
//     */
//    public function findGroupByUser(User $user)
//    {
//
//        $q = $this
//            ->createQueryBuilder('g')
//            ->where('g.name = ?1')
//            ->setParameter(1, $user->getType());
//
//        return $q->getQuery()->getSingleResult();
//    }

}