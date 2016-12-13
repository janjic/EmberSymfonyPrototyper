<?php

namespace UserBundle\Business\Manager\Role;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Role;

/**
 * Class JsonApiUpdateRoleManagerTrait
 * @package UserBundle\Business\Manager\Role
 */
trait JsonApiUpdateRoleManagerTrait
{

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

        return $this->createJsonAPiUpdateResponse($result);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiUpdateResponse($data)
    {
        switch (get_class($data)) {
            case UniqueConstraintViolationException::class:
                return AgentApiResponse::ROLE_ALREADY_EXIST;
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Role::class && ($id = $data->getId())):
                return AgentApiResponse::ROLE_EDITED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }
}