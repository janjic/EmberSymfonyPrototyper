<?php

namespace UserBundle\Adapter;


use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use UserBundle\Business\Manager\UserManager;
use UserBundle\Entity\Address;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\User;

/**
 * Class UserJQGRIDListConverter
 *
 * @package Alligator\Adapter\User
 */
class UserSaveConverter extends JQGridConverter
{
    /**
     * @param UserManager $manager
     * @param Request     $request
     * @param string      $param
     */
    public function __construct(UserManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @return mixed
     */
    public function convert()
    {
        $userJson = json_decode($this->request->getContent())->user;
        $userObj = new User();
        $userObj->setFirstName($userJson->firstName)
            ->setLastName($userJson->lastName)
            ->setUsername($userJson->email);
        $userObj->setEmail($userJson->email);
        $userObj->setLanguage($userJson->language);
        $userObj->setComment($userJson->comment);
        $userObj->setPlainPassword($userJson->password);
        $userObj->setIsAdmin($userJson->isAdmin);

//        $userObj->setBirthDate($userJson->birthDate);
        $userObj->setBirthDate(new \DateTime());

        $imageObj = new Image();
        $imageObj->setBase64Content($userJson->image->base64_content);
        $imageObj->setName($userJson->image->name);

        $addressObj = new Address();
        $addressObj->setStreetNumber($userJson->address->streetNumber)
        ->setCity($userJson->address->streetNumber)
        ->setCountry($userJson->address->country)
        ->setPhone($userJson->address->phone)
        ->setPostcode($userJson->address->postcode);

//        Debug::dump($imageObj);exit;
        try {
            $imageObj->saveToFile($imageObj->getBase64Content());
        } catch (Exception $e)
        {
            throw $e;
        }

        $userObj->setAddress($addressObj);

        $userObj = $this->manager->save($userObj);

        $this->request->attributes->set($this->param, new ArrayCollection(array($userObj)));
    }
}