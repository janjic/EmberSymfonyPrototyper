<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 15.12.16.
 * Time: 12.48
 */

namespace UserBundle\Business\Manager\Settings;

use CoreBundle\Adapter\AgentApiResponse;
use UserBundle\Entity\Group;
use UserBundle\Entity\Settings\Settings;
use UserBundle\Entity\Settings\Bonus;
use Exception;

/**
 * Class JsonApiSaveBonusManagerTrait
 * @package UserBundle\Business\Manager\Settings
 */
trait JsonApiSaveBonusManagerTrait
{
    /**
     * @param $data
     * @return array
     */
    public function saveResource($data)
    {
        /** @var Bonus $bonus */
        $bonus = $this->deserializeBonus($data);

        $bonus->setSettings($this->repository->getReferenceForClass($bonus->getSettings()->getId(), Settings::class));
        $bonus->setGroup($this->repository->getReferenceForClass($bonus->getGroup()->getId(), Group::class));

        $result = $this->repository->saveBonus($bonus);

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