<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use UserBundle\Business\Repository\RoleRepository;
use UserBundle\Entity\Role;

/**
 * Class RoleManager
 * @package UserBundle\Business\Manager
 */
class RoleManager implements BasicEntityManagerInterface
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

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->repository->getAll();
    }

}