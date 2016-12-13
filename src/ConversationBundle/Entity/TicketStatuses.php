<?php

namespace ConversationBundle\Entity;


/**
 * Class TicketStatuses
 * @package ConversationBundle\Entity
 */
class TicketStatuses
{
    const STATUS_NEW    = 'NEW';
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_SOLVED = 'SOLVED';


    /**
     * @return array
     */
    public static function getPossibleValues()
    {
        return array(static::STATUS_NEW, static::STATUS_ACTIVE, static::STATUS_SOLVED);
    }

    /**
     * @return array
     */
    public static function getReadables()
    {
        return array(static::STATUS_NEW => self::STATUS_NEW, static::STATUS_ACTIVE => self::STATUS_ACTIVE, static::STATUS_SOLVED => self::STATUS_SOLVED);
    }
}