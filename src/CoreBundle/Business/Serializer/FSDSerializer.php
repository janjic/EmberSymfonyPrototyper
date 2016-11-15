<?php

namespace CoreBundle\Business\Serializer;

use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use UserBundle\Business\Schema\Group\GroupProxySchema;
use UserBundle\Business\Schema\Group\GroupSchema;
use UserBundle\Business\Schema\Role\RoleProxySchema;
use UserBundle\Business\Schema\Role\RoleSchema;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

class FSDSerializer
{
    public static function serialize($data, $instancesArray = null)
    {
        if ($instancesArray == null) {
            $instancesArray = [
                Group::class => GroupSchema::class,
                Role::class  => RoleSchema::class,

                'Proxies\__CG__\UserBundle\Entity\Role' => RoleProxySchema::class,
                'Proxies\__CG__\UserBundle\Entity\Group' => GroupProxySchema::class
            ];
        }

        $encoder = Encoder::instance($instancesArray, new EncoderOptions(0, $_SERVER['PHP_SELF']));

        return $encoder->encodeData($data);
    }
}