<?php

namespace UserBundle\Business\Repository;

use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\EntityRepository;
use Exception;
use UserBundle\Entity\Group;

/**
 * Class GroupRepository
 * @package UserBundle\Business\Repository
 */
class GroupRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

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
     * @param $groupName
     * @return mixed
     */
    public function findGroupByName($groupName)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS, self::ROLES_ALIAS);
        $qb->leftJoin(self::ALIAS.'.roles', self::ROLES_ALIAS);

        $qb->where(self::ALIAS.'.name = :group_name')
            ->setParameter('group_name', $groupName);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Save new group
     * @param Group $group
     * @return Group|Exception
     */
    public function saveGroup($group)
    {
        try {
            $this->_em->persist($group);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $group;
    }

    /**
     * @param Group $group
     * @return Group|Exception
     */
    public function editGroup($group)
    {
        try {
            $this->_em->merge($group);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $group;
    }

    /**
     * @param int $oldGroupId
     * @param int $newGroupId
     * @return boolean|Exception
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
            return $e;
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
            return $e;
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