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
    const ACCESS_DENIED                             = 403;

    const PASSWORD_ALREADY_REQUESTED                = 41;
    const MAIL_SENT_TO_USER                         = 21;
    const PASSWORDS_CHANGED_OK                      = 22;
    const USER_WITH_TOKEN_DOES_NOT_EXIST            = 24;
    const PASSWORDS_ARE_NOT_SAME                    = 25;
    const USER_WITH_EMAIL_DOES_NOT_EXIST            = 26;
    const OLD_PASSWORD_IS_NOT_CORRECT               = 27;

    /** AGENT */
    const AGENT_ALREADY_EXIST                       = 28;
    const AGENT_SAVED_SUCCESSFULLY                  = 29;
    const AGENT_NOT_FOUND                           = 30;
    const AGENT_CURRENTLY_INACTIVE                  = 31;
    const AGENT_INFO_CALCULATED_OK                  = 32;
    const AGENT_SYNC_ERROR                          = 33;
    const AGENT_PARENT_CHANGE_ERROR_RESPONSE        = 34;
    const AGENT_DELETED_SUCCESSFULLY                = 35;
    const AGENT_DELETE_ERROR                        = 36;
    const AGENT_DELETE_SYNC_ERROR                   = 37;
    const AGENT_NEW_INFO_OK                         = 38;

    /** ROLE */
    const ROLE_SAVED_SUCCESSFULLY                   = 2001;
    const ROLE_EDITED_SUCCESSFULLY                  = 2002;
    const ROLE_DELETED_SUCCESSFULLY                 = 2003;
    const ROLE_ALREADY_EXIST                        = 2004;

    /** GROUP */
    const GROUP_SAVED_SUCCESSFULLY                   = 2101;
    const GROUP_EDITED_SUCCESSFULLY                  = 2102;
    const GROUP_DELETED_SUCCESSFULLY                 = 2103;
    const GROUP_ALREADY_EXIST                        = 2104;
    const GROUP_CHANGE_FOR_USERS_FAILED              = 2105;

    /** TICKET */
    const TICKET_SAVED_SUCCESSFULLY                  = 2201;
    const TICKET_NOT_FOUND                           = 2230;
    const TICKET_THREAD_NOT_SAVED                    = 2231;


    /** MESSAGES */
    const MESSAGES_UNSUPPORTED_FORMAT                = 2301;
    const MESSAGES_DRAFT_ERROR                       = 2302;
    const MESSAGES_NEW_INFO                          = 2303;

    /** THREAD */
    const THREAD_EDITED_SUCCESSFULLY                 = 2251;

    /** MAIL LIST */
    const MAIL_LIST_SAVED_SUCCESSFULLY               = 2301;
    const MAIL_CAMPAIGN_SAVED_SUCCESSFULLY           = 2401;

    /** INVITATION */
    const INVITATION_SAVED_SUCCESSFULLY              = 2501;

    /** SETTINGS */
    const SETTINGS_SAVED_SUCCESSFULLY                = 2601;
    const SETTINGS_EDITED_SUCCESSFULLY               = 2602;

    /** NOTIFICATION */
    CONST NOTIFICATION_EDITED_SUCCESSFULLY           = 2701;

    /** PAYMENT INFO */
    CONST PAYMENT_EXECUTED_SUCCESSFULLY              = 3000;
    CONST PAYMENT_EXECUTE_ERROR                      = 3001;
    const PAYMENT_NEW_INFO_OK                        = 3002;
}