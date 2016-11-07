<?php

namespace UserBundle\Adapter;

use CoreBundle\Adapter\AdapterInterface;
use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use UserBundle\Business\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserAdapter
 *
 * @package Alligator\Adapter\User
 */
class UserAdapter extends BaseAdapter
{
    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * @param string  $param
     * @param Request $request
     *
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {

        $type = __NAMESPACE__."\\".ucfirst($param).UserAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->userManager, $request, $param);
    }
}