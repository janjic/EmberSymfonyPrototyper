<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;


/**
 * Class UserRepository
 * @package UserBundle\Business\Repository
 */
class UserRepository extends EntityRepository
{

    public function findUsers ($id = null)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u.id', 'u.firstName', 'u.lastName', 'u.baseImageUrl  as image', 'u.username');
        $id ? $qb->where('u.id = ?1')->setParameter(1, $id):false;

        return  $qb->select()->getQuery()->getArrayResult();
    }
}