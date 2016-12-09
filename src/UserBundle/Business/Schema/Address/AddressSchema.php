<?php

namespace UserBundle\Business\Schema\Address;

use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Group;

class AddressSchema extends SchemaProvider
{
    protected $resourceType = 'address';

    public function getId($address)
    {
        /** @var Address $address */
        return $address->getId();
    }

    public function getAttributes($address)
    {
        /** @var Address $address */
        return [
            'street_number' => $address->getStreetNumber(),
            'postcode'      => $address->getPostcode(),
            'city'          => $address->getCity(),
            'country'       => $address->getCountry(),
            'phone'         => $address->getPhone(),
            'fixed_phone'   => $address->getFixedPhone(),
        ];
    }

    public function getRelationships($agent, $isPrimary, array $includeList)
    {
        /** @var Agent $agent */
        return [];
    }

    public function getIncludePaths(){
        return [];
    }

}