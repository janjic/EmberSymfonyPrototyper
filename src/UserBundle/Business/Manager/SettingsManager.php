<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\Settings\JsonApiGetSettingsManagerTrait;
use UserBundle\Business\Manager\Settings\JsonApiSaveSettingsManagerTrait;
use UserBundle\Business\Manager\Settings\JsonApiUpdateSettingsManagerTrait;
use UserBundle\Business\Repository\SettingsRepository;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Entity\Settings\Bonus;
use UserBundle\Entity\Settings\Commission;
use UserBundle\Entity\Settings\Settings;

/**
 * Class SettingsManager
 * @package UserBundle\Business\Manager
 */
class SettingsManager implements JSONAPIEntityManagerInterface
{
    use BasicEntityManagerTrait;
    use JsonApiSaveSettingsManagerTrait;
    use JsonApiGetSettingsManagerTrait;
    use JsonApiUpdateSettingsManagerTrait;
    public function deleteResource($id = null){}


    /**
     * @var SettingsRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @var CommissionManager
     */
    protected $commissionManager;

    /**
     * @param SettingsRepository $repository
     * @param FJsonApiSerializer $fSerializer
     * @param CommissionManager $commissionManager
     */
    public function __construct(SettingsRepository $repository, FJsonApiSerializer $fSerializer, CommissionManager $commissionManager)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
        $this->commissionManager = $commissionManager;
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeSettings($content, $mappings = null)
    {
        $relations = array('image', 'bonuses', 'commissions', 'bonuses.group', 'commissions.group');

        if (!$mappings) {
            $mappings = array(
                'settings'          => array('class' => Settings::class, 'type'=>'settings'),
                'image'             => array('class' => Image::class,  'type'=>'images'),
                'bonuses'           => array('class' => Bonus::class,  'type'=>'bonuses'),
                'commissions'       => array('class' => Commission::class,  'type'=>'commissions'),
                'group'             => array('class' => Group::class,  'type'=>'groups')
            );
        }


        return $this->fSerializer->setDeserializationClass(Settings::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function serializeSettings($content, $mappings = null)
    {
        $relations = array('image', 'bonuses', 'commissions', 'bonuses.group', 'commissions.group');

        if (!$mappings) {
            $mappings = array(
                'settings'          => array('class' => Settings::class, 'type'=>'settings'),
                'image'             => array('class' => Image::class,  'type'=>'images'),
                'bonuses'           => array('class' => Bonus::class,  'type'=>'bonuses'),
                'commissions'       => array('class' => Commission::class,  'type'=>'commissions'),
                'group'             => array('class' => Group::class,  'type'=>'groups')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations, array(),AgentSerializerInfo::$basicFields)->toArray();
    }
}