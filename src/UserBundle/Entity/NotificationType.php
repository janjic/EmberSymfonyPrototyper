<?php

namespace UserBundle\Entity;

/**
 * Class NotificationType
 * @package UserBundle\Entity
 */
class NotificationType
{
    const NEW_AGENT_NOTIFICATION     = 'NEW AGENT NOTIFICATION';
    const NEW_PAYMENT_NOTIFICATION   = 'NEW PAYMENT NOTIFICATION';
    const NEW_MESSAGE_NOTIFICATION   = 'NEW MESSAGE NOTIFICATION';


    /**
     * @return array
     */
    public static function getPossibleValues()
    {
        return array(static::NEW_AGENT_NOTIFICATION, static::NEW_PAYMENT_NOTIFICATION, static::NEW_MESSAGE_NOTIFICATION);
    }

    /**
     * @return array
     */
    public static function getReadables()
    {
        return array(static::NEW_AGENT_NOTIFICATION => self::NEW_AGENT_NOTIFICATION, static::NEW_PAYMENT_NOTIFICATION => self::NEW_PAYMENT_NOTIFICATION, static::NEW_MESSAGE_NOTIFICATION => self::NEW_MESSAGE_NOTIFICATION);
    }

}