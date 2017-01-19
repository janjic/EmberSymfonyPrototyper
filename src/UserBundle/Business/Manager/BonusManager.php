<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\Settings\JsonApiSaveBonusManagerTrait;
use UserBundle\Business\Repository\BonusRepository;
use UserBundle\Entity\Group;
use UserBundle\Entity\Settings\Bonus;
use UserBundle\Entity\Settings\Settings;

/**
 * Class BonusManager
 * @package UserBundle\Business\Manager
 */
class BonusManager implements JSONAPIEntityManagerInterface
{
    use JsonApiSaveBonusManagerTrait;
    public function getResource($id = null){}
    public function deleteResource($id = null){}
    public function updateResource($id = null){}

    /**
     * @var BonusRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @param BonusRepository $repository
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(BonusRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeBonus($content, $mappings = null)
    {
        $relations = array('settings', 'group');

        if (!$mappings) {
            $mappings = array(
                'bonus'  => array('class' => Bonus::class, 'type'=>'bonus'),
                'settings'    => array('class' => Settings::class,  'type'=>'settings'),
                'group'    => array('class' => Group::class,  'type'=>'groups')
            );
        }

        return $this->fSerializer->setDeserializationClass(Bonus::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function serializeBonus($content, $mappings = null)
    {
        $relations = array('settings', 'group');

        if (!$mappings) {
            $mappings = array(
                'bonus'    => array('class' => Bonus::class,  'type'=>'bonus'),
                'settings'  => array('class' => Settings::class, 'type'=>'settings'),
                'group'    => array('class' => Group::class,  'type'=>'groups')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
    }

    /**
     * @param Group $group
     * @return Bonus|null
     */
    public function getBonusForGroup(Group $group)
    {
        return $this->repository->getBonusForGroup($group);
    }
}