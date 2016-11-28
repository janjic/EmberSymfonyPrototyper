<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\Common\Util\Debug;
use UserBundle\Business\Repository\RoleRepository;
use UserBundle\Entity\Role;

/**
 * Class RoleManager
 * @package UserBundle\Business\Manager
 */
class RoleManager implements JSONAPIEntityManagerInterface
{
    /**
     * @var RoleRepository
     */
    protected $repository;

    /**
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

//    /**
//     * @return array
//     */
//    public function getAll()
//    {
//        return $this->repository->getAll();
//    }
//
//    /**
//     * @param mixed $role
//     * @return mixed
//     */
//    public function addRole($role)
//    {
//        $newRole = new Role($role->role);
//        $newRole->setName($role->name);
//
//        return $this->repository->saveItem($newRole);
//    }
//
//    /**
//     * @param int   $id
//     * @param mixed $role
//     * @return bool|mixed
//     */
//    public function changeNested($id, $role)
//    {
//        if ($role->simpleUpdate) {
//            /** @var Role $roleDB */
//            $roleDB = $this->repository->findOneById($id);
//            $roleDB->setRole($role->role);
//            $roleDB->setName($role->name);
//            $roleDB->setId($id);
//
//            return $this->repository->simpleUpdate($roleDB);
//        }
//
//        return $this->repository->changeNested($id, intval($role->prev), intval($role->parent), $role->name, $role->role);
//    }
//
//    /**
//     * @param int $id
//     * @return bool
//     */
//    public function removeNestedFromTree($id)
//    {
//        return $this->repository->removeNestedFromTree($id);
//    }
//
//
//    /**
//     * @param $id
//     * @return mixed
//     */
//    public function findRoleById($id)
//    {
//        return $this->repository->findOneById($id);
//    }
    public function getResource($id = null)
    {
        return $this->repository->findRole($id);
    }

    public function saveResource($data)
    {
        // TODO: Implement saveResource() method.
    }

    public function updateResource($data)
    {
        // TODO: Implement updateResource() method.
    }

    public function deleteResource($id)
    {
        // TODO: Implement deleteResource() method.
    }


}