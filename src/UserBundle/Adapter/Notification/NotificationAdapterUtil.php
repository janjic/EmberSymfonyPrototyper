<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 21.12.16.
 * Time: 14.45
 */

namespace UserBundle\Adapter\Notification;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class SettingsAdapterUtil
 * @package UserBundle\Adapter\Settings
 */
class NotificationAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const notifications_API = 'notificationsAPI';
}