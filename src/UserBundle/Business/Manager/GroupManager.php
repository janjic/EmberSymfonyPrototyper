<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\Common\Util\Debug;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Repository\GroupRepository;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class GroupManager
 * @package UserBundle\Business\Manager
 */
class GroupManager implements JSONAPIEntityManagerInterface
{
    /**
     * @var GroupRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @param GroupRepository $repository
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(GroupRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
    }

//    /**
//     * Get all groups
//     * @return array
//     */
//    public function findAllGroups()
//    {
//        return $this->repository->findAllGroups();
//    }
//
//    /**
//     * @param object $newGroup
//     * @return mixed
//     */
//    public function addGroup($newGroup)
//    {
//        $group = new Group($newGroup->name);
////        $roles = $this->container->getRolesFromArray($newGroup->getRolesCollection()->toArray());
////        $newGroup->resetRolesCollection();
////        /** @var Role $role */
////        foreach ($roles as $role) {
////            $role->addGroup($newGroup);
////        }
//
//        return $this->repository->saveGroup($group);
//    }
//
//    /**
//     * Remove group
//     * @param int $groupId
//     * @param int $newParentId
//     * @return bool
//     */
//    public function deleteGroup($groupId, $newParentId)
//    {
//        /** @var Group $group */
//        $group = $this->getGroupById($groupId);
//        if (!$group) {
//            return false;
//        }
//
//        if (!$this->repository->changeUsersGroup($group->getId(), $newParentId)) {
//            return false;
//        }
//
//        /** @var Role $role */
//        foreach ($group->getRolesCollection() as $role) {
//            $role->removeGroup($group);
//        }
//
//        return $this->repository->removeGroup($group);
//    }
//
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


    /**
     * @param null $id
     * @return mixed
     *
     *
     *  NEW!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     *
     *
     */
    public function getResource($id = null)
    {
        return $this->repository->findGroup($id);
    }

    public function saveResource($data)
    {
        Debug::dump($this->deserializeGroup($data));die();
        // TODO: Implement saveResource() method.
    }

    public function updateResource($data)
    {
        $content = json_decode($data)->data;
        $newRoles = 'a';
        var_dump($content);die();

        /** @var Group $groupDb */
        $groupDb = $this->repository->findOneById($content->id);
        $groupDb->setName('as');
        Debug::dump($groupDb);die();

        var_dump($data);die();
    }

    public function deleteResource($content)
    {
        $content = json_decode($content);

        /** @var Group $group */
        $group = $this->repository->findOneById($content->id);
        if (!$group) {
            return false;
        }

        if (!$this->repository->changeUsersGroup($group->getId(), $content->newParent)) {
            return false;
        }

        /** @var Role $role */
        foreach ($group->getRolesCollection() as $role) {
            $role->removeGroup($group);
        }

        return $this->repository->removeGroup($group);
    }

    public function deserializeGroup($content, $mappings = null)
    {
        $relations = array('roles');
        if (!$mappings) {
            $mappings = array(
                'group'   => array('class' => Group::class, 'type'=>'groups')
            );
        }

        return $this->fSerializer->setDeserializationClass(Group::class)->deserialize($content, $mappings, $relations);
    }
}