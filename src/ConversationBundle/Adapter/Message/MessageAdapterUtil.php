<?php

namespace ConversationBundle\Adapter\Message;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class MessageAdapterUtil
 * @package ConversationBundle\Adapter\Message
 */
abstract class MessageAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const MESSAGE_API = 'messageAPI';

}