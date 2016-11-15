<?php

namespace UserBundle\Business\Manager;
use CoreBundle\Adapter\JQGridInterface;
use CoreBundle\Business\Manager\BasicEntityManagerInterface;
use DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Business\Event\UserEventContainer;
use UserBundle\Business\Repository\UserRepository;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\User;

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
     * @param User $user
     * @return UserRepository
     */
    public function save(User $user)
    {
        return $this->repository->save($user);
    }

    /**
     * @param  $user
     * @return UserRepository
     */
    public function edit($user, $id)
    {
        /**
         * @var User $dbUser
         */
        $dbUser = $this->repository->findOneById($id);
        $dbUser->setFirstName($user->firstName);
        $dbUser->setLastName($user->lastName);
        $dbUser->setUsername($user->email);
        $dbUser->setEmail($user->email);
        $dbUser->setPlainPassword($user->password);
        $dbUser->setLanguage($user->language);

        $dbUser->setBirthDate(new DateTime($user->birthDate));
        $dbUser->getAddress()->setStreetNumber($user->address->streetNumber);
        $dbUser->getAddress()->setPostcode($user->address->postcode);
        $dbUser->getAddress()->setCity($user->address->city);
        $dbUser->getAddress()->setCountry($user->address->country);
        $dbUser->getAddress()->setPhone($user->address->phone);
        if(!property_exists($user->image,'id')){
            $img  = new Image();
            $img->setBase64Content($user->image->base64_content);
            $img->setName($user->image->name);
            $img->saveToFile($img->getBase64Content());
            $dbUser->getImage()->setName($img->getName());
            $dbUser->setBaseImageUrl($img->getWebPath());
        }
        return $this->repository->edit($dbUser);
    }

    /**
     * @param $image
     */
    public function deleteImage($image)
    {
        $this->eventContainer->deleteImage($image);
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

    /**
     * @param $id
     * @return mixed
     */
    public function findImageById($id)
    {
        return $this->eventContainer->findImageById($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findAddressById($id)
    {
        return $this->eventContainer->findAddressById($id);
    }

}