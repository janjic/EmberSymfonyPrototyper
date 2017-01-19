<?php

namespace UserBundle\Business\Manager\Settings;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Entity\Settings\Bonus;
use UserBundle\Entity\Settings\Commission;
use UserBundle\Entity\Settings\Settings;

/**
 * Class JsonApiUpdateSettingsManagerTrait
 * @package UserBundle\Business\Manager\Settings
 */
trait JsonApiUpdateSettingsManagerTrait
{
    /**
     * @param string $data
     * @return mixed
     */
    public function updateResource($data)
    {
        /** @var Settings $settings */
        $settings = $this->deserializeSettings($data);
//        var_dump($settings->getCommissions());die();

        //1. reference
        $dbSettings = $this->getEntityReference($settings->getId());

        /** @var Commission $commission */
        foreach( $settings->getCommissions() as $commission){
            $commission->setGroup($this->repository->getReferenceForClass($commission->getId(), Commission::class)->getGroup());
        }
        /** @var Bonus $bonus */
        foreach( $settings->getBonuses() as $bonus){
            $bonus->setGroup($this->repository->getReferenceForClass($bonus->getId(), Bonus::class)->getGroup());
        }

        $this->setAndValidateImage($settings, $dbSettings);

        $settingsOrException = $this->repository->editSettings($settings);

        if ($settingsOrException instanceof Exception) {
            !is_null($image = $settings->getImage()) ? $image->deleteFile() : false;
        }


        return $this->createJsonAPiSettingsResponse($settingsOrException);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSettingsResponse($data)
    {
        switch (get_class($data)) {
            case UniqueConstraintViolationException::class:
                return AgentApiResponse::GROUP_ALREADY_EXIST;
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Settings::class && ($id = $data->getId())):
                return AgentApiResponse::SETTINGS_EDITED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }

    /**
     * @param Settings $settings
     * @param Settings $dbSettings
     */
    private function setAndValidateImage (Settings $settings, Settings $dbSettings)
    {
        /**
         * @var Image $dbImage
         */
        //SETTINGS ALREADY HAVE IMAGE
        //2, managed by entity manager
        if ($dbImage = $dbSettings->getImage()) {
            //Agent not have image, we must delete old image from file and DB
            if (is_null($settings->getImage())) {
                ($img = $dbSettings->getImage()) ? $img->deleteFile() :false;
                $dbSettings->setImage(null);
                //Agent changed his/her image, we must only update image
            } else if ( !$settings->getImage()->getId() ) {
                $dbImage->setBase64Content($settings->getImage()->getBase64Content());
                $settings->setImage($dbImage);
                $settings->getImage()->setId(null);
                $dbImage->deleteFile();
                $this->saveMedia($settings);
            }
            //DB AGENT IS WITHOUT IMAGE, we must add new
        } else {
            $settings->setImage($settings->getImage());
            if( $settings->getImage() != null ) {
                $settings->getImage()->setId(null);
            }
            $this->saveMedia($settings);
        }

    }

    /**
     * @param Settings $settings
     * @return bool
     */
    protected function saveMedia($settings)
    {
        /** @var Image|null $image */
        $image = $settings->getImage();
        if(!is_null($image)){
            if ($image->saveToFile($image->getBase64Content())) {
                $image->updateFileSize();
                return true;
            }
            return false;
        }
        return true;
    }
}