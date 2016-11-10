<?php

namespace UserBundle\Adapter;


use CoreBundle\Adapter\JQGridConverter;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Exception;
use Symfony\Component\HttpFoundation\Request;
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
        $userObj->setBirthDate(new DateTime($userJson->birthDate));

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
        $userObj->setImage($imageObj);
        $userObj->setBaseImageUrl($userObj->getImage()->getWebPath());
        $userObj->setAddress($addressObj);

        $userObj = $this->manager->save($userObj);

        if($userObj->getId()){
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'user' => array('id' => $userObj->getId(), 'username', $userObj->getUsername()),
                'meta' => array('code'=> 200, 'message', 'User successfully saved'))));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'user' => array('id' => null),
                'meta' => array('code'=> 410, 'message', 'User not saved'))));
        }
    }
}