<?php

namespace UserBundle\Business\Repository;

use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use UserBundle\Entity\Settings\Commission;
use Doctrine\ORM\EntityRepository;
use Exception;

/**
 * Class CommissionRepository
 * @package UserBundle\Business\Repository
 */
class CommissionRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS       = 'commission';

    /**
     * Save new Commission
     * @param Commission $commission
     * @return Commission|Exception
     */
    public function saveCommission($commission)
    {
        try {
            $this->_em->persist($commission);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }

        return $commission;
    }
}