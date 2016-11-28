<?php
namespace FSerializerBundle\Test;

use FSerializerBundle\Serializer\JsonApiMenu;
use FSerializerBundle\Serializer\JsonApiRelationship;
use FSerializerBundle\Serializer\JsonApiSerializerAbstract;
use UserBundle\Entity\Address;
use UserBundle\Entity\Document\Image;

class AddressSerializer extends JsonApiSerializerAbstract
{
    protected $type = 'address';

    /**
     * @param Address $address
     * @param array|null $fields
     * @return array
     */
    public function getAttributes($address, array $fields = null)
    {
        return [
            'street_number' => $address?$address->getStreetNumber():null,
            'postcode'      => $address?$address->getPostcode():null,
            'city'          => $address?$address->getCity():null,
            'country'       => $address?$address->getCountry():null,
            'phone'         => $address?$address->getPhone():null,
            'fixed_phone'   => $address?$address->getFixedPhone():null,
        ];
    }

    public function getDeserializationClass()
    {
        return Address::class;
    }
}