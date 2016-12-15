<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 15.12.16.
 * Time: 12.10
 */

namespace UserBundle\Business\Manager\Settings;

use CoreBundle\Adapter\AgentApiResponse;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Settings\Settings;
use Exception;

/**
 * Class JsonApiSaveInvitationManagerTrait
 * @package UserBundle\Business\Manager\Settings
 */
trait JsonApiSaveSettingsManagerTrait
{
    /**
     * @param $data
     * @return array
     */
    public function saveResource($data)
    {
        /** @var Settings $settings */
        $settings = $this->deserializeSettings($data);

        $result = $this->repository->saveSettings($settings);

        return $this->createJsonAPiSaveResponse($result);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        switch (get_class($data)) {
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Settings::class && ($id = $data->getId())):
                return AgentApiResponse::ROLE_SAVED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }
}