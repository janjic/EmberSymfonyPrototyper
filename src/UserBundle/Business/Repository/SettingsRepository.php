<?php

namespace UserBundle\Business\Repository;

use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use UserBundle\Entity\Settings\Settings;
use Doctrine\ORM\EntityRepository;
use Exception;

/**
 * Class SettingsRepository
 * @package UserBundle\Business\Repository
 */
class SettingsRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS       = 'settings';

    /**
     * Save new Settings
     * @param Settings $settings
     * @return Settings|Exception
     */
    public function saveSettings($settings)
    {
        try {
            $this->_em->persist($settings);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $settings;
    }
}