<?php

namespace UserBundle\Adapter\TCRUser;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\TCRUserManager;

/**
 * Class TCRUserAdapter
 * @package UserBundle\Adapter\TCRUser
 */
class TCRUserAdapter extends BaseAdapter
{
    /**
     * @var TCRUserManager
     */
    private $tcrUserManager;

    /**
     * @param TCRUserManager $tcrUserManager
     */
    public function __construct(TCRUserManager $tcrUserManager)
    {
        $this->tcrUserManager = $tcrUserManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).TCRUserAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->tcrUserManager, $request, $param);
    }
}