<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 13.12.16.
 * Time: 12.47
 */

namespace UserBundle\Adapter\Invitation;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class InvitationAdapterUtil
 * @package UserBundle\Adapter\Invitation
 */
class InvitationAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const INVITATION_API = 'invitationAPI';
}