<?php

namespace UserBundle\Business\Manager;
use CoreBundle\Adapter\JQGridInterface;
use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Business\Event\UserEventContainer;
use UserBundle\Entity\Document\File;

/**
 * Class FileManager
 * @package UserBundle\Business\Manager
 */
class FileManager implements BasicEntityManagerInterface
{
    /**
     * @var FileRepository
     */
    protected $repository;

    /**
     * @var UserEventContainer
     */
    protected $eventContainer;


    /**
     * @param FileRepository $repository
     */
    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param File $file
     * @return mixed
     */
    public function save(File $file)
    {
        return $this->repository->save($file);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findFileById($id)
    {
        return $this->repository->findOneById($id);
    }

}