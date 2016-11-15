<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Exception;
use UserBundle\Entity\Address;
use UserBundle\Entity\User;


/**
 * Class AddressRepository
 * @package UserBundle\Business\Repository
 */
class AddressRepository extends EntityRepository
{
    const ALIAS = 'address';


    public function save(Address $address)
    {
        try {
            $this->_em->persist($address);
            $this->_em->flush();
        } catch (Exception $e)
        {
            return new Address();
        }

        return $address;
    }
}