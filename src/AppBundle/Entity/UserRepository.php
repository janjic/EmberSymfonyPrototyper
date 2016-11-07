<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;


/**
 * Class UserRepository
 * @package AppBundle\Entity
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