<?php

namespace UserBundle\Business\Manager\Settings;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Business\Manager\Agent\SaveMediaTrait;
use UserBundle\Entity\Document\Image;
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

        $dbSettings = $this->getEntityReference($settings->getId());

        $this->setAndValidateImage($settings, $dbSettings);

        /** @var Commission $commission */
        $commission = $settings->getCommissions()[0];

        /** @var Commission $commissionDB */
        $commissionDB = $this->commissionManager->findCommissionById($commission->getId());

        $commissionDB->setSetupFee($commission->getSetupFee())
            ->setPackages($commission->getPackages())
            ->setConnect($commission->getConnect())
            ->setStream($commission->getStream());

        $settingsOrException = $this->repository->editSettings($settings);

        if ($settingsOrException instanceof Exception) {
            !is_null($image = $settings->getImage()) ? $image->deleteFile() : false;
        }

//        var_dump($settings);
//        var_dump($settingsOrException);die();

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
//                var_dump('usao');
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