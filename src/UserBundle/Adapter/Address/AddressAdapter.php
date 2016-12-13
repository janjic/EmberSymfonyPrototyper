<?php

namespace UserBundle\Adapter\Address;

use CoreBundle\Adapter\AdapterInterface;
use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use UserBundle\Business\Manager\AddressManager;
use UserBundle\Business\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ImageAdapter
 *
 * @package Alligator\Adapter\User
 */
class AddressAdapter extends BaseAdapter
{
    /**
     * @param AddressManager $addressManager
     */
    public function __construct(AddressManager $addressManager)
    {
        $this->addressManager = $addressManager;
    }


    /**
     * @param string  $param
     * @param Request $request
     *
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {

        $type = __NAMESPACE__."\\".ucfirst($param).AddressAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->addressManager, $request, $param);
    }
}