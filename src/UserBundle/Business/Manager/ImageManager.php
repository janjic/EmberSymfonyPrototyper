<?php

namespace UserBundle\Business\Manager;
use CoreBundle\Adapter\JQGridInterface;
use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Business\Event\UserEventContainer;
use UserBundle\Business\Repository\ImageRepository;
use UserBundle\Business\Repository\UserRepository;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\User;

/**
 * Class ImageManager
 * @package UserBundle\Business\Manager
 */
class ImageManager implements BasicEntityManagerInterface
{
    /**
     * @var ImageRepository
     */
    protected $repository;

    /**
     * @var UserEventContainer
     */
    protected $eventContainer;


    /**
     * @param ImageRepository    $repository
     * @param UserEventContainer $eventContainer
     */
    public function __construct(ImageRepository $repository, UserEventContainer $eventContainer)
    {
        $this->repository = $repository;
        $this->eventContainer = $eventContainer;
    }

    /**
     * @param Image $image
     * @return mixed
     */
    public function save(Image $image)
    {
        return $this->repository->save($image);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findImageById($id)
    {
        return $this->repository->findOneById($id);
    }



}