<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 15.12.16.
 * Time: 13.05
 */

namespace UserBundle\Adapter\Settings;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class SettingsAdapterUtil
 * @package UserBundle\Adapter\Settings
 */
class SettingsAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const settings_API = 'settingsAPI';
}