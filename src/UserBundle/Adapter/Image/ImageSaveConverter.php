<?php

namespace UserBundle\Adapter\Image;


use CoreBundle\Adapter\BasicConverter;
use CoreBundle\Adapter\JQGridConverter;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\ImageManager;
use UserBundle\Entity\Address;
use UserBundle\Entity\Document\Image;

/**
 * Class UserJQGRIDListConverter
 *
 * @package Alligator\Adapter\User
 */
class ImageSaveConverter extends BasicConverter
{
    /**
     * @param ImageManager $manager
     * @param Request      $request
     * @param string       $param
     */
    public function __construct(ImageManager $manager, Request $request, $param)
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
        $imageJson = $json->attributes;
        $imageObj = new Image();
        $imageObj->setBase64Content($imageJson->base64_content);
        $imageObj->setName($imageJson->name);
        $imageObj->saveToFile($imageObj->getBase64Content());
        $userObj = $this->manager->save($imageObj);
        if($userObj->getId()){
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'data' => array('type' => 'images', 'id' => $imageObj->getId()),
                'meta' => array('code'=> 200, 'message', 'Image successfully saved'))));
        } else {
            $this->request->attributes->set($this->param, new ArrayCollection(array(
                'data' => array('id' => null),
                'meta' => array('code'=> 500, 'message', 'Image not saved'))));
        }
    }
}