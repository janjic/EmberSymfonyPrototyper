<?php

namespace UserBundle\Adapter\Image;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class ImageAdapterUtil
 * @package UserBundle\Adapter
 */
abstract class ImageAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';
    /** parameters for user entity */
    const IMAGE_SAVE_CONVERTER   = 'imageSave';

}