<?php

namespace UserBundle\Business\Manager;
use CoreBundle\Adapter\JQGridInterface;
use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use UserBundle\Business\Event\UserEventContainer;
use UserBundle\Business\Repository\UserRepository;

/**
 * Class UserManager
 * @package UserBundle\Business\Manager
 */
class UserManager implements BasicEntityManagerInterface, JQGridInterface
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserEventContainer
     */
    protected $eventContainer;


    /**
     * @param UserRepository     $repository
     * @param UserEventContainer $eventContainer
     */
    public function __construct(UserRepository $repository, UserEventContainer $eventContainer)
    {
        $this->repository = $repository;
        $this->eventContainer = $eventContainer;
    }

    /**
     * @param array $searchParams
     * @param array $sortParams
     * @param array $additionalParams
     * @return mixed
     */
    public function searchForJQGRID($searchParams, $sortParams = array(), $additionalParams = array())
    {
        return $this->repository->searchUsersForJQGRID($searchParams, $sortParams, $additionalParams);
    }

    /**
     * @param int $page
     * @param int $offset
     * @param array $sortParams
     * @param array $additionalParams
     * @return mixed
     */
    public function findAllForJQGRID($page, $offset, $sortParams, $additionalParams = array())
    {
        if ($searchParam = $this->eventContainer->getSearchParam()) {
            $additionalParams['search_param'] = $searchParam;
        }

        return  $this->repository->findAllUsersForJQGRID($page, $offset, $sortParams, $additionalParams);
    }

    /**
     * @param null $searchParams
     * @param null $sortParams
     * @param array $additionalParams
     * @return mixed
     */
    public function getCountForJQGRID($searchParams = null, $sortParams = null, $additionalParams = array())
    {
        if (!$searchParams) {

            return $this->repository->searchUsersForJQGRID(null, $sortParams, $additionalParams, true);
        }

        return $this->repository->searchUsersForJQGRID($searchParams, $sortParams, $additionalParams, true);
    }

}