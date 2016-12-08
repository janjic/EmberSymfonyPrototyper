<?php

namespace UserBundle\Business\Manager\Role;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Role;

/**
 * Class JsonApiDeleteRoleManagerTrait
 * @package UserBundle\Business\Manager\Role
 */
trait JsonApiDeleteRoleManagerTrait
{
    /**
     * @param $id
     * @return array
     */
    public function deleteResource($id)
    {
        $result = $this->repository->removeNestedFromTree($id);

        return $this->createJsonAPiDeleteResponse($result);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiDeleteResponse($data)
    {
        switch (get_class($data)) {
            case (Role::class && ($id = $data->getId())):
                return AgentApiResponse::ROLE_DELETED_SUCCESSFULLY;
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            default:
                return false;
        }
    }
}