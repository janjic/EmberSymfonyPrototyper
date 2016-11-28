<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiSerializerAbstract;
use UserBundle\Entity\Document\Image;

class ImageSerializer extends JsonApiSerializerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getId($model)
    {
        return $model->getId();
    }

    protected $type = 'images';

    /**
     * @param Image $image
     * @param array|null $fields
     * @return array
     */
    public function getAttributes($image, array $fields = null)
    {
        return [
            'file_path' => $image ?$image->getFilePath():null,
            'web_path'  => $image ?$image->getWebPath():null,
            'name'      => $image ?$image->getName():   null,
            ];
    }

    public function getDeserializationClass()
    {
       return Image::class;
    }
}