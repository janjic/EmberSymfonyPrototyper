<?php

namespace CoreBundle\Business\Serializer;

use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use UserBundle\Business\Schema\Address\AddressProxySchema;
use UserBundle\Business\Schema\Address\AddressSchema;
use UserBundle\Business\Schema\Agent\AgentProxySchema;
use UserBundle\Business\Schema\Agent\AgentSchema;
use UserBundle\Business\Schema\Group\GroupProxySchema;
use UserBundle\Business\Schema\Group\GroupSchema;
use UserBundle\Business\Schema\ImageProxySchema;
use UserBundle\Business\Schema\ImageSchema;
use UserBundle\Business\Schema\Role\RoleProxySchema;
use UserBundle\Business\Schema\Role\RoleSchema;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Business\Schema\TCRUser\TCRUserSchema;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;
use UserBundle\Entity\TCRUser;

class FSDSerializer
{
    public static $schemaMappings = [
        Group::class   => GroupSchema::class,
        Role::class    => RoleSchema::class,
        Agent::class   => AgentSchema::class,
        Address::class => AddressSchema::class,
        Image::class   => ImageSchema::class,
        TCRUser::class => TCRUserSchema::class,

        'Proxies\__CG__\UserBundle\Entity\Role'           => RoleProxySchema::class,
        'Proxies\__CG__\UserBundle\Entity\Group'          => GroupProxySchema::class,
        'Proxies\__CG__\UserBundle\Entity\Agent'          => AgentProxySchema::class,
        'Proxies\__CG__\UserBundle\Entity\Address'        => AddressProxySchema::class,
        'Proxies\__CG__\UserBundle\Entity\Document\Image' => ImageProxySchema::class,
    ];

    public static function serialize($data, $meta = [], $instancesArray = null)
    {
        if ($instancesArray == null) {
            $instancesArray = self::$schemaMappings;
        }

        $encoder = Encoder::instance($instancesArray, new EncoderOptions(0, ($self = $_SERVER['PHP_SELF']) == '/app.php' ? null : $self))->withMeta($meta);

        return $encoder->encodeData($data);
    }
}