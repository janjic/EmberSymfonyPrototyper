<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 15.12.16.
 * Time: 16.29
 */

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
        return $this->serializeSettings($this->repository->findSettings($id));
    }
}