<?php

namespace CoreBundle\Business\Serializer;

use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use UserBundle\Business\Schema\Group\GroupProxySchema;
use UserBundle\Business\Schema\Group\GroupSchema;
use UserBundle\Business\Schema\ImageSchema;
use UserBundle\Business\Schema\Role\RoleProxySchema;
use UserBundle\Business\Schema\Role\RoleSchema;
use UserBundle\Business\Schema\TCRUser\TCRUserSchema;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;
use UserBundle\Entity\TCRUser;

class FSDSerializer
{
    public static function serialize($data, $meta = [], $instancesArray = null)
    {
        if ($instancesArray == null) {
            $instancesArray = [
                Group::class    => GroupSchema::class,
                Role::class     => RoleSchema::class,
                TCRUser::class  => TCRUserSchema::class,
                Image::class    => ImageSchema::class,

                'Proxies\__CG__\UserBundle\Entity\Role' => RoleProxySchema::class,
                'Proxies\__CG__\UserBundle\Entity\Group' => GroupProxySchema::class
            ];
        }

        $encoder = Encoder::instance($instancesArray, new EncoderOptions(0, $_SERVER['PHP_SELF']))->withMeta($meta);

        return $encoder->encodeData($data);
    }
}