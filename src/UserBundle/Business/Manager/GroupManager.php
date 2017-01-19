<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\Group\JsonApiDeleteGroupManagerTrait;
use UserBundle\Business\Manager\Group\JsonApiGetGroupManagerTrait;
use UserBundle\Business\Manager\Group\JsonApiSaveGroupManagerTrait;
use UserBundle\Business\Manager\Group\JsonApiUpdateGroupManagerTrait;
use UserBundle\Business\Repository\GroupRepository;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class GroupManager
 * @package UserBundle\Business\Manager
 */
class GroupManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiGetGroupManagerTrait;
    use JsonApiSaveGroupManagerTrait;
    use JsonApiUpdateGroupManagerTrait;
    use JsonApiDeleteGroupManagerTrait;

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
     * @param int $id
     * @return mixed
     */
    public function getGroupById($id)
    {
        return $this->getResource($id);
    }

    /**
     * @param $groupName
     * @return mixed
     */
    public function getGroupByName($groupName)
    {
        return $this->serializeGroup($this->repository->findGroupByName($groupName));
    }

    /**
     * @param $name
     * @return mixed
     */
    public function findGroupByName($name)
    {
        return $this->repository->findGroupByName($name);
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

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
    }

    /**
     * @param $id
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     */
    public function getReference($id)
    {
        return $this->repository->getEntityReference($id);
    }
}