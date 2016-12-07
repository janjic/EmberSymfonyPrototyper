<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
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
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
    }

    public function getResource($id = null)
    {
        return $this->repository->findRole($id);
    }

    public function saveResource($data)
    {
        return $this->repository->saveItem($this->deserializeRole($data));
    }

    public function updateResource($data)
    {
        $rawData = json_decode($data, true);

        if ($rawData['data']['attributes']['simple-update']) {
            /** @var Role $role */
            $role = $this->deserializeRole($data);
            /** @var Role $roleDB */
            $roleDB = $this->getResource($role->getId());
            $roleDB->setRole($role->getRole());
            $roleDB->setName($role->getName());

            return $this->repository->simpleUpdate($roleDB);
        }

        $prev = $rawData['data']['attributes']['prev'];
        $parent = $rawData['data']['relationships']['parent']['data']['id'];

        return $this->repository->changeNested($rawData['data']['id'], intval($prev), intval($parent));
    }

    public function deleteResource($id)
    {
        return $this->repository->removeNestedFromTree($id);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeRole($content, $mappings = null)
    {
        if (!$mappings) {
            $mappings = array('roles'  => array('class' => Role::class, 'type'=>'roles'));
        }

        return $this->fSerializer->setDeserializationClass(Role::class)->deserialize($content, $mappings, []);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function serializeRole($content, $mappings = null)
    {
        if (!$mappings) {
            $mappings = array(
                'roles'  => array('class' => Role::class, 'type'=>'roles'),
                'parent' => array('class' => Role::class, 'type'=>'roles')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, ['parent']);
    }

}