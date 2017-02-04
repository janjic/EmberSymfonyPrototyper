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
    const COMMISSION  = 'commissions';
    const BONUS       = 'bonuses';
    const IMAGE       = 'image';

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

    /**
     * @return array|Settings|null
     */
    public function findSettings()
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS);
        $qb->leftJoin(self::ALIAS.'.'.self::BONUS, self::BONUS)
            ->leftJoin(self::ALIAS.'.'.self::COMMISSION, self::COMMISSION)
            ->leftJoin(self::BONUS.'.group','bonusGroup')
            ->leftJoin(self::COMMISSION.'.group','commissionGroup');

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Settings $settings
     * @return Settings|Exception
     */
    public function editSettings($settings)
    {
        try {
            $this->_em->merge($settings);
            $this->_em->flush();
        } catch (Exception $e) {
           return $e;
        }

        return $settings;
    }

    /**
     * @return array|Settings|null
     */
    public function getLogo()
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::IMAGE.'.name as imgName');
        $qb->leftJoin(self::ALIAS.'.'.self::IMAGE, self::IMAGE);

        return $qb->getQuery()->getOneOrNullResult();
    }
}