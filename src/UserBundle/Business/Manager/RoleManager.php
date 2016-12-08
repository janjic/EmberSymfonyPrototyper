<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Adapter\AgentApiResponse;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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

    /**
     * @param null $id
     * @return array
     */
    public function getResource($id = null)
    {
        return $this->serializeRole($this->repository->findRole($id));
    }

    /**
     * @param $data
     * @return array
     */
    public function saveResource($data)
    {
        $result = $this->repository->saveItem($this->deserializeRole($data));
        if ($result instanceof Role) {
            return AgentApiResponse::ROLE_SAVED_SUCCESSFULLY($result->getId());
        } else if ($result instanceof UniqueConstraintViolationException) {
            return AgentApiResponse::ROLE_ALREADY_EXIST;
        }

        return AgentApiResponse::ERROR_RESPONSE($result);
    }

    /**
     * @param $data
     * @return array
     */
    public function updateResource($data)
    {
        $rawData = json_decode($data, true);

        if ($rawData['data']['attributes']['simple-update']) {
            /** @var Role $role */
            $role = $this->deserializeRole($data);
            /** @var Role $roleDB */
            $roleDB = $this->repository->findRole($role->getId());
            $roleDB->setRole($role->getRole());
            $roleDB->setName($role->getName());

            $result = $this->repository->simpleUpdate($roleDB);
        } else {
            $prev = $rawData['data']['attributes']['prev'];
            $parent = $rawData['data']['relationships']['parent']['data']['id'];

            $result = $this->repository->changeNested($rawData['data']['id'], intval($prev), intval($parent));
        }

        if ($result instanceof Role) {
            return AgentApiResponse::ROLE_EDITED_SUCCESSFULLY($result->getId());
        } else if ($result instanceof UniqueConstraintViolationException) {
            return AgentApiResponse::ROLE_ALREADY_EXIST;
        }

        return AgentApiResponse::ERROR_RESPONSE($result);
    }

    public function deleteResource($id)
    {
        $result = $this->repository->removeNestedFromTree($id);

        if ($result instanceof \Exception) {
            return AgentApiResponse::ERROR_RESPONSE($result);
        }

        return AgentApiResponse::ROLE_DELETED_SUCCESSFULLY;
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

        return $this->fSerializer->serialize($content, $mappings, ['parent'])->toArray();
    }

}