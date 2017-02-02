<?php

namespace UserBundle\Business\Manager\Settings;

/**
 * Class JsonApiGetSettingsManagerTrait
 * @package UserBundle\Business\Manager\Settings
 */
trait JsonApiGetSettingsManagerTrait
{
    /**
     * @param null $id
     * @return array
     */
    public function getResource($id = null)
    {
        return $this->serializeSettings($this->repository->findSettings());
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->repository->findSettings();
    }
}