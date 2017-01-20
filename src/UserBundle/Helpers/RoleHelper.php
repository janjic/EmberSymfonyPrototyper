<?php

namespace UserBundle\Helpers;


/**
 * Class RoleHelper
 * @package UserBundle\Helpers
 */
class RoleHelper
{

    const PORTAL_VERMITTLER     = 'Vermittler';
    const PORTAL_AGENT          = 'Agent';
    const PORTAL_ACTIVE_AGENT   = 'Active Agent';
    const PORTAL_MASTER_AGENT   = 'Master Agent';
    const PORTAL_AMBASSADOR     = 'Ambassador';
    const PORTAL_AMBASSADOR_1   = 'AMBASSADOR';
    const PORTAL_APP_PARTNER    = 'App Partner';
    const PORTAL_SAMSUNG        = 'SAMSUNG';
    const PORTAL_REFEREE        = 'Referee';
    const PORTAL_ADMIN          = 'ADMIN';
    const PORTAL_ACTIVE         = 'ACTIVE';


    const REFEREE    = 'REFEREE';
    const ACTIVE     = 'ACTIVE';
    const MASTER     = 'MASTER';
    const AMBASSADOR = 'AMBASSADOR';
    const ADMIN      = 'ADMIN';

    private static $mappings = array(
                        self::PORTAL_VERMITTLER     => self::REFEREE,
                        self::PORTAL_SAMSUNG        => self::REFEREE,
                        self::PORTAL_APP_PARTNER    => self::REFEREE,
                        self::PORTAL_REFEREE        => self::REFEREE,
                        self::PORTAL_AGENT          => self::ACTIVE,
                        self::PORTAL_ACTIVE_AGENT   => self::ACTIVE,
                        self::PORTAL_MASTER_AGENT   => self::MASTER,
                        self::PORTAL_AMBASSADOR     => self::AMBASSADOR,
                        self::PORTAL_AMBASSADOR_1   => self::AMBASSADOR,
                        self::PORTAL_ADMIN          => self::ACTIVE,
                        self::PORTAL_ACTIVE         => self::ACTIVE,
                        self::REFEREE               => self::REFEREE,
                        self::MASTER                => self::MASTER,
    );

    /**
     * @return array
     */
    public static function getMappings(): array
    {
        return self::$mappings;
    }


}