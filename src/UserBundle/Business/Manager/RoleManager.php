<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Adapter\AgentApiResponse;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\Role\JsonApiDeleteRoleManagerTrait;
use UserBundle\Business\Manager\Role\JsonApiGetRoleManagerTrait;
use UserBundle\Business\Manager\Role\JsonApiSaveRoleManagerTrait;
use UserBundle\Business\Manager\Role\JsonApiUpdateRoleManagerTrait;
use UserBundle\Business\Repository\RoleRepository;
use UserBundle\Entity\Role;

/**
 * Class RoleManager
 * @package UserBundle\Business\Manager
 */
class RoleManager implements JSONAPIEntityManagerInterface
{
    use JsonApiGetRoleManagerTrait;
    use JsonApiSaveRoleManagerTrait;
    use JsonApiUpdateRoleManagerTrait;
    use JsonApiDeleteRoleManagerTrait;

    const ROLE_SUPER_ADMIN  = "ROLE_SUPER_ADMIN";
    const ROLE_AMBASSADOR   = "ROLE_AMBASSADOR";
    const ROLE_MASTER_AGENT = "ROLE_MASTER_AGENT";
    const ROLE_ACTIVE_AGENT = "ROLE_ACTIVE_AGENT";
    const ROLE_REFEREE      = "ROLE_REFEREE";

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
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(RoleRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository  = $repository;
        $this->fSerializer = $fSerializer;
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