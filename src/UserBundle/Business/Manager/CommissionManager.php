<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\Settings\JsonApiSaveCommisionManagerTrait;
use UserBundle\Business\Repository\CommissionRepository;
use UserBundle\Entity\Group;
use UserBundle\Entity\Settings\Commission;
use UserBundle\Entity\Settings\Settings;

/**
 * Class CommissionManager
 * @package UserBundle\Business\Manager
 */
class CommissionManager implements JSONAPIEntityManagerInterface
{
    use JsonApiSaveCommisionManagerTrait;
    public function getResource($id = null){}
    public function deleteResource($id = null){}
    public function updateResource($id = null){}

    /**
     * @var CommissionRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @param CommissionRepository $repository
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(CommissionRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeCommission($content, $mappings = null)
    {
        $relations = array('settings', 'group');

        if (!$mappings) {
            $mappings = array(
                'commission'  => array('class' => Commission::class, 'type'=>'commissions'),
                'settings'    => array('class' => Settings::class,  'type'=>'settings'),
                'group'    => array('class' => Group::class,  'type'=>'groups')
            );
        }

        return $this->fSerializer->setDeserializationClass(Commission::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function serializeCommission($content, $mappings = null)
    {
        $relations = array('settings', 'group');

        if (!$mappings) {
            $mappings = array(
                'commission'    => array('class' => Commission::class,  'type'=>'commissions'),
                'settings'  => array('class' => Settings::class, 'type'=>'settings'),
                'group'    => array('class' => Group::class,  'type'=>'groups')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
    }
}