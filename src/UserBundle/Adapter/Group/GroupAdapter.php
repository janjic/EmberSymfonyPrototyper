<?php

namespace UserBundle\Adapter\Group;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\GroupManager;

/**
 * Class GroupAdapter
 * @package UserBundle\Adapter\Group
 */
class GroupAdapter extends BaseAdapter
{
    /**
     * @param GroupManager $groupManager
     */
    public function __construct(GroupManager $groupManager)
    {
        $this->groupManager = $groupManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).GroupAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->groupManager, $request, $param);
    }
}