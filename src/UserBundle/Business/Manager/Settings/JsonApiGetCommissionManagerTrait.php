<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 16.12.16.
 * Time: 13.27
 */

namespace UserBundle\Business\Manager\Settings;

/**
 * Class JsonApiGetSettingsManagerTrait
 * @package UserBundle\Business\Manager\Settings
 */
trait JsonApiGetCommissionManagerTrait
{
    /**
     * @param null $id
     * @return array
     */
    public function getResource($id = null)
    {
        return $this->serializeCommission($this->repository->findCommission($id));
    }
}