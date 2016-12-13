<?php

namespace ConversationBundle\Adapter\Ticket;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TicketAdapter
 * @package ConversationBundle\Adapter\Ticket
 */
class TicketAdapter extends BaseAdapter
{
    /**
     * TicketAdapter constructor.
     * @param TicketManager $ticketManager
     */
    public function __construct(TicketManager $ticketManager)
    {
        $this->ticketManager = $ticketManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).TicketAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->ticketManager, $request, $param);
    }
}