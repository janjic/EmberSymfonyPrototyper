<?php

namespace UserBundle\Adapter\User;


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
        $json = json_decode($this->request->getContent())->data;
        $userJson = $json->attributes;

        $userObj = new User();
        $userObj->setFirstName($userJson->first_name)
            ->setLastName($userJson->last_name)
            ->setUsername($userJson->email);
        $userObj->setEmail($userJson->email);
        $userObj->setLanguage($userJson->language);
        $userObj->setComment($userJson->comment);
        $userObj->setPlainPassword($userJson->password);
        $userObj->setIsAdmin($userJson->is_admin);
        $userObj->setBirthDate(new DateTime($userJson->birth_date));

        $imageId = $json->relationships->image->data->id;
        $image = $this->manager->findImageById($imageId);

        $userObj->setImage($image);

        $addressId = $json->relationships->address->data->id;
        $address = $this->manager->findAddressById($addressId);

        $userObj->setAddress($address);

        $userObj = $this->manager->save($userObj);

        if($userObj->getId()){
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'data' => array('type'=> 'users', 'id' => $userObj->getId()),
                'meta' => array('code'=> 200, 'message', 'User successfully saved'))));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'user' => array('id' => null),
                'meta' => array('code'=> 500, 'message', 'User not saved'))));
        }
    }
}