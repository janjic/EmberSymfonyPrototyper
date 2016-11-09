<?php

namespace UserBundle\Adapter\Role;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\RoleManager;

/**
 * Class RoleAdapter
 * @package UserBundle\Adapter\Role
 */
class RoleAdapter extends BaseAdapter
{
    /**
     * @var RoleManager
     */
    private $roleManager;

    /**
     * @param RoleManager $roleManager
     */
    public function __construct(RoleManager $roleManager)
    {
        $this->roleManager = $roleManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).RoleAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->roleManager, $request, $param);
    }
}