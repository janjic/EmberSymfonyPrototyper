<?php

namespace UserBundle\Business\Manager\Settings;

use CoreBundle\Adapter\AgentApiResponse;
use UserBundle\Entity\Group;
use UserBundle\Entity\Settings\Settings;
use UserBundle\Entity\Settings\Commission;
use Exception;

/**
 * Class JsonApiSaveCommisionManagerTrait
 * @package UserBundle\Business\Manager\Settings
 */
trait JsonApiSaveCommisionManagerTrait
{
    /**
     * @param $data
     * @return array
     */
    public function saveResource($data)
    {
        /** @var Commission $commission */
        $commission = $this->deserializeCommission($data);

        $commission->setSettings($this->repository->getReferenceForClass($commission->getSettings()->getId(), Settings::class));
        $commission->setGroup($this->repository->getReferenceForClass($commission->getGroup()->getId(), Group::class));

        $result = $this->repository->saveCommission($commission);

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