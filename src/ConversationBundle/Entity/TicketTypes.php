<?php

namespace ConversationBundle\Entity;

/**
 * Class TicketTypes
 * @package ConversationBundle\Entity
 */
class TicketTypes
{
    const BUG_REPORT    = 'BUG REPORT';
    const WRONG_ORDER   = 'WRONG ORDER';
    const ORDER_INQUIRY = 'WRONG INQUIRY';


    /**
     * @return array
     */
    public static function getPossibleValues()
    {
        return array(static::BUG_REPORT, static::WRONG_ORDER, static::ORDER_INQUIRY);
    }

    /**
     * @return array
     */
    public static function getReadables()
    {
        return array(static::BUG_REPORT => self::BUG_REPORT, static::WRONG_ORDER => self::WRONG_ORDER, static::ORDER_INQUIRY => self::ORDER_INQUIRY);
    }
}