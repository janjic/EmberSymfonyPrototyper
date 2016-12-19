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
     * @param $id
     * @return array|Settings|null
     */
    public function findSettings($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS);

        if(intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')->setParameter('id', $id)
                ->leftJoin(self::ALIAS.'.'.self::BONUS, self::BONUS)
                ->leftJoin(self::ALIAS.'.'.self::COMMISSION, self::COMMISSION);

            return $qb->getQuery()->getOneOrNullResult();
        }
        return $qb->getQuery()->getResult();
    }
}