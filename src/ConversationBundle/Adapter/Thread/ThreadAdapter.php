<?php

namespace ConversationBundle\Adapter\Thread;

use ConversationBundle\Business\Manager\ThreadManager;
use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ThreadAdapter
 * @package ConversationBundle\Adapter\Thread
 */
class ThreadAdapter extends BaseAdapter
{
    /**
     * @var ThreadManager
     */
    protected $threadManager;

    /**
     * @param ThreadManager $threadManager
     */
    public function __construct(ThreadManager $threadManager)
    {
        $this->threadManager = $threadManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).ThreadAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->threadManager, $request, $param);
    }
}