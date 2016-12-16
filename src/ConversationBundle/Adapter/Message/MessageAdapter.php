<?php

namespace ConversationBundle\Adapter\Message;

use ConversationBundle\Business\Manager\MessageManager;
use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MessageAdapter
 * @package ConversationBundle\Adapter\Message
 */
class MessageAdapter extends BaseAdapter
{
    /**
     * @var MessageManager
     */
    protected $messageManager;

    /**
     * @param MessageManager $messageManager
     */
    public function __construct(MessageManager $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).MessageAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->messageManager, $request, $param);
    }
}