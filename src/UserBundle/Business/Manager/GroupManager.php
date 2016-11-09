<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use UserBundle\Business\Repository\GroupRepository;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class GroupManager
 * @package UserBundle\Business\Manager
 */
class GroupManager implements BasicEntityManagerInterface
{
    /**
     * @var GroupRepository
     */
    protected $repository;

    /**
     * @param GroupRepository $repository
     */
    public function __construct(GroupRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all groups
     * @return array
     */
    public function findAllGroups()
    {
        return $this->repository->findAllGroups();
    }

    /**
     * @param object $newGroup
     * @return bool
     */
    public function addGroup($newGroup)
    {
        $group = new Group($newGroup->name);
//        $roles = $this->container->getRolesFromArray($newGroup->getRolesCollection()->toArray());
//        $newGroup->resetRolesCollection();
//        /** @var Role $role */
//        foreach ($roles as $role) {
//            $role->addGroup($newGroup);
//        }

        return $this->repository->saveGroup($group);
    }

    /**
     * Remove group
     * @param int $groupId
     * @param int $newParentId
     * @return bool
     */
    public function deleteGroup($groupId, $newParentId)
    {
        /** @var Group $group */
        $group = $this->getGroupById($groupId);
        if (!$group) {
            return false;
        }

        if (!$this->repository->changeUsersGroup($group->getId(), $newParentId)) {
            return false;
        }

        /** @var Role $role */
        foreach ($group->getRolesCollection() as $role) {
            $role->removeGroup($group);
        }

        return $this->repository->removeGroup($group);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getGroupById($id)
    {
        try {
            return $this->repository->findOneById($id);
        } catch (\Exception $e) {
            return null;
        }
    }

}