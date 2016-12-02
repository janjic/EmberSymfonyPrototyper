<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
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

    /**
     * @param null $id
     * @return mixed
     */
    public function getResource($id = null)
    {
        return $this->repository->findGroup($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getGroupById($id)
    {
        return $this->getResource($id);
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function saveResource($data)
    {
        /** @var Group $group */
        $group = $this->deserializeGroup($data);
        $roles = $group->getRoles();
        foreach ($roles as $role) {
            $group->removeRole($role);
            $group->addRole($this->repository->createReference($role->getId(), Role::class));
        }

        return $this->repository->saveGroup($group);
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function updateResource($data)
    {
        /** @var Group $group */
        $group = $this->deserializeGroup($data);

        /** @var Group $groupDb */
        $groupDb = $this->repository->findGroup($group->getId());
        $groupDb->setName($group->getName());
        $groupDb->setRoles([]);
        foreach ($group->getRoles() as $role) {
            $groupDb->addRole($this->repository->createReference($role->getId(), Role::class));
        }

        return $this->repository->editGroup($groupDb);
    }

    /**
     * @param null $content
     * @return mixed
     */
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

        return $this->repository->removeGroup($group);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeGroup($content, $mappings = null)
    {
        $relations = array('roles');
        if (!$mappings) {
            $mappings = array(
                'group'  => array('class' => Group::class, 'type'=>'groups'),
                'roles'  => array('class' => Role::class, 'type'=>'roles')
            );
        }

        return $this->fSerializer->setDeserializationClass(Group::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function serializeGroup($content, $mappings = null)
    {
        $relations = array('roles');
        if (!$mappings) {
            $mappings = array(
                'group'  => array('class' => Group::class, 'type'=>'groups'),
                'roles'  => array('class' => Role::class, 'type'=>'roles')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations);
    }
}