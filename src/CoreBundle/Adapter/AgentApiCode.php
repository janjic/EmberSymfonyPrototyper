<?php

namespace CoreBundle\Adapter;

/**
 * Class AgentApiCode
 * @package CoreBundle\Adapter
 */
class AgentApiCode
{

    const ERROR_MESSAGE                             = 404;
    const FILE_SAVING_ERROR                         = 401;

    const PASSWORD_ALREADY_REQUESTED                = 41;
    const MAIL_SENT_TO_USER                         = 21;
    const PASSWORDS_CHANGED_OK                      = 22;
    const USER_WITH_TOKEN_DOES_NOT_EXIST            = 24;
    const PASSWORDS_ARE_NOT_SAME                    = 25;
    const USER_WITH_EMAIL_DOES_NOT_EXIST            = 26;
    const OLD_PASSWORD_IS_NOT_CORRECT               = 27;

    const AGENT_ALREADY_EXIST                       = 28;
    const AGENT_SAVED_SUCCESSFULLY                  = 29;
    const AGENT_NOT_FOUND                           = 30;


}