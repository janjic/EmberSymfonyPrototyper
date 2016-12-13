<?php

namespace ConversationBundle\Adapter\Ticket;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class TicketAdapterUtil
 * @package ConversationBundle\Bundle\Adapter\Ticket.
 */
abstract class TicketAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const TICKET_API = 'ticketAPI';

}