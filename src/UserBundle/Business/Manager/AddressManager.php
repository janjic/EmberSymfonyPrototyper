<?php

namespace UserBundle\Business\Manager;
use CoreBundle\Adapter\JQGridInterface;
use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use CoreBundle\Business\Manager\BasicEntityManagerTrait;
use DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Business\Event\UserEventContainer;
use UserBundle\Business\Repository\AddressRepository;
use UserBundle\Business\Repository\ImageRepository;
use UserBundle\Business\Repository\UserRepository;
use UserBundle\Entity\Address;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\User;

/**
 * Class AddressManager
 * @package UserBundle\Business\Manager
 */
class AddressManager implements BasicEntityManagerInterface
{
    use BasicEntityManagerTrait;
    /**
     * @var AddressRepository
     */
    protected $repository;


    /**
     * @param AddressRepository  $repository
     */
    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param Address $address
     * @return mixed
     */
    public function save(Address $address)
    {
        return $this->repository->save($address);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findAddressById($id)
    {
        return $this->repository->findOneById($id);
    }
}