<?php

namespace UserBundle\Business\Repository;

use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Exception;
use UserBundle\Entity\Address;



/**
 * Class AddressRepository
 * @package UserBundle\Business\Repository
 */
class AddressRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

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