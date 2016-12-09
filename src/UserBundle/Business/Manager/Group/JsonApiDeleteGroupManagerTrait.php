<?php

namespace UserBundle\Business\Manager\Group;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class JsonApiDeleteGroupManagerTrait
 * @package UserBundle\Business\Manager\Group
 */
trait JsonApiDeleteGroupManagerTrait
{
    /**
     * @param null $content
     * @return mixed
     */
    public function deleteResource($content)
    {
        $content = json_decode($content);

        /** @var Group $group */
        $group = $this->repository->findOneById($content->id);

        if (!$this->repository->changeUsersGroup($group->getId(), $content->newParent)) {
            return AgentApiResponse::GROUP_CHANGE_FOR_USERS_FAILED;
        }

        return $this->createJsonAPiDeleteResponse($this->repository->removeGroup($group));
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiDeleteResponse($data)
    {
        if ($data == true) {
            return AgentApiResponse::GROUP_DELETED_SUCCESSFULLY;
        }

        return AgentApiResponse::ERROR_RESPONSE($data);
    }
}