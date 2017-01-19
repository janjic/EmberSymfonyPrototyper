<?php

namespace UserBundle\Business\Repository;

use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use UserBundle\Entity\Group;
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
    const GROUP_ALIAS = 'gr';

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

    /**
     * @param Group $group
     * @return Bonus|null
     */
    public function getBonusForGroup(Group $group)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);

        $qb->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);

        $qb->where(self::GROUP_ALIAS.'.id = ?1');
        $qb->setParameter(1, $group->getId());

        return $qb->getQuery()->getOneOrNullResult();
    }
}