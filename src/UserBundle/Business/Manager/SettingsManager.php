<?php

namespace UserBundle\Business\Manager;

use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\Settings\JsonApiSaveSettingsManagerTrait;
use UserBundle\Business\Repository\SettingsRepository;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Settings\Settings;

/**
 * Class SettingsManager
 * @package UserBundle\Business\Manager
 */
class SettingsManager implements JSONAPIEntityManagerInterface
{
    use JsonApiSaveSettingsManagerTrait;
    public function getResource($id = null){}
    public function deleteResource($id = null){}
    public function updateResource($id = null){}

    /**
     * @var SettingsRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @param SettingsRepository $repository
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(SettingsRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeSettings($content, $mappings = null)
    {
        $relations = array('image');

        if (!$mappings) {
            $mappings = array(
                'settings'  => array('class' => Settings::class, 'type'=>'settings'),
                'image'    => array('class' => Image::class,  'type'=>'images')
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
        $relations = array('image');

        if (!$mappings) {
            $mappings = array(
                'settings'  => array('class' => Settings::class, 'type'=>'settings'),
                'image'    => array('class' => Image::class,  'type'=>'images')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
    }
}