<?php

namespace UserBundle\Business\Schema\TCRUser;

use Neomerx\JsonApi\Schema\SchemaProvider;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\TCRUser;

/**
 * Class TCRUserSchema
 * @package UserBundle\Business\Schema\TCRUser
 */
class TCRUserSchema extends SchemaProvider
{
    protected $resourceType = 'tcr-users';

    public function getId($entity)
    {
        return $entity->getId();
    }

    /**
     * @param TCRUser $entity
     * @return array
     */
    public function getAttributes($entity)
    {
        return [
            'first-name'   => $entity->getName(),
            'last-name'    => $entity->getSurname(),
            'birth-date'   => is_object($bd = $entity->getBirthDate()) ? $bd : new \DateTime($bd),
            'title'        => $entity->getTitle(),
            'language'     => $entity->getLanguage(),
            'address'      => $entity->getAddress(),
            'phone-number' => $entity->getPhoneNumber(),
            'company'      => $entity->getCompany(),
            'country'      => $entity->getCountry(),
            'zip'          => $entity->getZip(),
            'comment'      => $entity->getComment(),
            'agent'        => $entity->getAgent(),
            'created-at'   => $entity->getCreatedAt(),
            'username'     => $entity->getUsername(),
            'enabled'      => $entity->isEnabled(),
            'email'        => $entity->getEmail(),
            'is-admin'     => $entity->isIsAdmin(),
        ];
    }

    /**
     * @param TCRUser $user
     * @param bool $isPrimary
     * @param array $includeList
     * @return array
     */
    public function getRelationships($user, $isPrimary, array $includeList)
    {
        return [
            'image' => [self::DATA => $user->getAvatar()],
            'agent' => [self::DATA => $user->getAgent()]
        ];
    }

    public function getIncludePaths(){
        return ['image', 'agent'];
    }
}