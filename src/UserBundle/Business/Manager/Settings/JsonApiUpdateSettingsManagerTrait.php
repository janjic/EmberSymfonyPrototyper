<?php

namespace UserBundle\Business\Manager\Settings;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
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
//        $data = json_decode($data);
////        var_dump($data->data->relationships->commissions->data[0]);
////        var_dump($data->data->relationships->bonuses->data[0]);die();
//
//        unset($data->data->relationships->commissions);
//
//        var_dump($data->data->relationships);die();
//        $data = json_encode($data);


        /** @var Settings $settings */
        $settings = $this->deserializeSettings($data);
var_dump('aa');
        var_dump($settings->getBonuses());die();

//        $commission = $this->commissionManager->findCommission($settings->getCommissions());


        return $this->createJsonAPiSettingsResponse($this->repository->editSettings($settings));
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
}