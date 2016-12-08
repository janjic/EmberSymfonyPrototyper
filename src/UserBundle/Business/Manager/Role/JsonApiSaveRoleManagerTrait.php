<?php

namespace UserBundle\Business\Manager\Role;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Role;

/**
 * Class JsonApiSaveRoleManagerTrait
 * @package UserBundle\Business\Manager\Role
 */
trait JsonApiSaveRoleManagerTrait
{

    /**
     * @param $data
     * @return array
     */
    public function saveResource($data)
    {
        $result = $this->repository->saveItem($this->deserializeRole($data));

        return $this->createJsonAPiSaveResponse($result);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        switch (get_class($data)) {
            case (Role::class && ($id = $data->getId())):
                return AgentApiResponse::ROLE_SAVED_SUCCESSFULLY($id);
            case UniqueConstraintViolationException::class:
                return AgentApiResponse::ROLE_ALREADY_EXIST;
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            default:
                return false;
        }
    }
}