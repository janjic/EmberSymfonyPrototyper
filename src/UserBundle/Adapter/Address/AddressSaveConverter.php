<?php

namespace UserBundle\Adapter\Address;


use CoreBundle\Adapter\BasicConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\AddressManager;
use UserBundle\Entity\Address;

/**
 * Class AddressSaveConverter
 *
 * @package Alligator\Adapter\User
 */
class AddressSaveConverter extends BasicConverter
{
    /**
     * @param AddressManager $manager
     * @param Request        $request
     * @param string         $param
     */
    public function __construct(AddressManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
    }

    /**
     * @return mixed
     */
    public function convert()
    {
        $json = json_decode($this->request->getContent())->data;
//        var_dump($json);exit;
        $addressJson = $json->attributes;
//        var_dump($addressJson);exit;
        $addressObj = new Address();
        $addressObj->setStreetNumber($addressJson->street_number)
            ->setCity($addressJson->city)
            ->setCountry($addressJson->country)
            ->setPhone($addressJson->phone)
            ->setPostcode($addressJson->postcode);

        $addressObj = $this->manager->save($addressObj);

        if($addressObj->getId()){
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'data' => array('type'=> 'addresses', 'id' => $addressObj->getId()),
                'meta' => array('code'=> 200, 'message', 'Address successfully saved'))));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'address' => array('id' => null),
                'meta' => array('code'=> 500, 'message', 'Address not saved'))));
        }
    }
}