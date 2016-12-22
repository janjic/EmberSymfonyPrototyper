<?php

namespace UserBundle\Business\Repository;

use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use UserBundle\Entity\Settings\Bonus;
use Doctrine\ORM\EntityRepository;
use Exception;

/**
 * Class BonusRepository
 * @package UserBundle\Business\Repository
 */
class BonusRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS       = 'bonus';

    /**
     * Save new Commission
     * @param Bonus $bonus
     * @return Bonus|Exception
     */
    public function saveBonus($bonus)
    {
        try {
            $this->_em->persist($bonus);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $bonus;
    }
}