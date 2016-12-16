<?php

namespace ConversationBundle\Adapter\Thread;

use CoreBundle\Adapter\BaseAdapterUtil;

/**
 * Class ThreadAdapterUtil
 * @package ConversationBundle\Adapter\Thread
 */
abstract class ThreadAdapterUtil extends BaseAdapterUtil
{
    /** each adapter class MUST end with this */
    const BASE_CONVERTER_NAME = 'Converter';

    /** parameters for user entity */
    const MESSAGE_API = 'threadAPI';

}