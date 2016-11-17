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
        $userJson = json_decode($this->request->getContent())->data;
        $userObj = new User();
        $userJsonAttrs = $userJson->attributes;

        $userObj->setFirstName($userJsonAttrs->first_name)
            ->setLastName($userJsonAttrs->last_name)
            ->setUsername($userJsonAttrs->email);
        $userObj->setEmail($userJsonAttrs->email);
        $userObj->setLanguage($userJsonAttrs->language);
        $userObj->setComment($userJsonAttrs->comment);
        $userObj->setPlainPassword($userJsonAttrs->password);
        $userObj->setIsAdmin($userJsonAttrs->is_admin);
        $userObj->setBirthDate(new DateTime($userJsonAttrs->birth_date));

        $imageObj = new Image();
        $imageJson = $userJson->relationships->image->data->attributes;
        $imageObj->setBase64Content($imageJson->base64_content);
        $imageObj->setName($imageJson->name);

        $addressObj = new Address();

        $addressJson = $userJson->relationships->address->data->attributes;
        $addressObj->setStreetNumber($addressJson->street_number)
            ->setCity($addressJson->city)
            ->setCountry($addressJson->country)
            ->setPhone($addressJson->phone)
            ->setPostcode($addressJson->postcode);
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
                'data' => array('type'=> 'users', 'id' => $userObj->getId()),
                'meta' => array('code'=> 200, 'message', 'User successfully saved'))));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'user' => array('id' => null),
                'meta' => array('code'=> 500, 'message', 'User not saved'))));
        }
    }
}