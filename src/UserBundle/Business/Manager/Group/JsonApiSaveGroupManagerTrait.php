<?php

namespace UserBundle\Business\Manager\Group;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class JsonApiSaveGroupManagerTrait
 * @package UserBundle\Business\Manager\Group
 */
trait JsonApiSaveGroupManagerTrait
{

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

        return $this->createJsonAPiSaveResponse($this->repository->saveGroup($group));
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        switch (get_class($data)) {
            case UniqueConstraintViolationException::class:
                return AgentApiResponse::GROUP_ALREADY_EXIST;
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Group::class && ($id = $data->getId())):
                return AgentApiResponse::GROUP_SAVED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }
}