<?php

namespace UserBundle\Business\Manager\Group;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class JsonApiUpdateGroupManagerTrait
 * @package UserBundle\Business\Manager\Group
 */
trait JsonApiUpdateGroupManagerTrait
{

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

        return $this->createJsonAPiUpdateResponse($this->repository->editGroup($groupDb));
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiUpdateResponse($data)
    {
        switch (get_class($data)) {
            case UniqueConstraintViolationException::class:
                return AgentApiResponse::GROUP_ALREADY_EXIST;
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Group::class && ($id = $data->getId())):
                return AgentApiResponse::GROUP_EDITED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }
}