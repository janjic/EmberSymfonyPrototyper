<?php

namespace UserBundle\Adapter\Image;

use CoreBundle\Adapter\AdapterInterface;
use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use UserBundle\Business\Manager\ImageManager;
use UserBundle\Business\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ImageAdapter
 *
 * @package Alligator\Adapter\User
 */
class ImageAdapter extends BaseAdapter
{
    /**
     * @param ImageManager $imageManager
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }


    /**
     * @param string  $param
     * @param Request $request
     *
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {

        $type = __NAMESPACE__."\\".ucfirst($param).ImageAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->imageManager, $request, $param);
    }
}