<?php

namespace CoreBundle\Adapter;
use Exception;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class AgentApiEvent
 * @package CoreBundle\Adapter
 */
class AgentApiResponse
{
    const SUCCESS_MAIL_SENT_RESPONSE            = array('status' => AgentApiCode::MAIL_SENT_TO_USER);
    const PASSWORDS_ARE_NOT_SAME_RESPONSE       = array('status' => AgentApiCode::PASSWORDS_ARE_NOT_SAME);
    const USER_WITH_TOKEN_NOT_EXIST_RESPONSE    = array('status' => AgentApiCode::USER_WITH_TOKEN_DOES_NOT_EXIST);
    const USER_WITH_EMAIL_NOT_EXIST_RESPONSE    = array('status' => AgentApiCode::USER_WITH_EMAIL_DOES_NOT_EXIST);
    const PASSWORDS_CHANGED_OK_RESPONSE         = array('status' => AgentApiCode::PASSWORDS_CHANGED_OK);
    const OLD_PASSWORD_IS_NOT_CORRECT_RESPONSE  = array('status' => AgentApiCode::OLD_PASSWORD_IS_NOT_CORRECT);
    const AGENT_NOT_FOUND_RESPONSE              = array('status' => AgentApiCode::AGENT_NOT_FOUND);

    const AGENT_ALREADY_EXIST                   = array('errors' => array(array('status'=> AgentApiCode::AGENT_ALREADY_EXIST)));
    const AGENT_SAVED_FILE_FAILED_RESPONSE      = array('errors' => array(array('status'=> AgentApiCode::FILE_SAVING_ERROR)));

    const ROLE_DELETED_SUCCESSFULLY             = array('meta' => array('status'=> AgentApiCode::ROLE_EDITED_SUCCESSFULLY));
    const ROLE_ALREADY_EXIST                    = array('errors' => array(array('status'=> AgentApiCode::ROLE_ALREADY_EXIST)));

    const GROUP_DELETED_SUCCESSFULLY            = array('meta' => array('status'=> AgentApiCode::GROUP_EDITED_SUCCESSFULLY));
    const GROUP_CHANGE_FOR_USERS_FAILED         = array('errors' => array(array('status'=> AgentApiCode::GROUP_CHANGE_FOR_USERS_FAILED)));
    const GROUP_ALREADY_EXIST                   = array('errors' => array(array('status'=> AgentApiCode::GROUP_ALREADY_EXIST)));

    const TICKET_NOT_FOUND_RESPONSE             = array('status' => AgentApiCode::TICKET_NOT_FOUND);
    const ACCESS_TO_TICKET_DENIED               = array('errors' => array(array('status' => AgentApiCode::ACCESS_DENIED)));


    const MESSAGES_UNSUPPORTED_FORMAT           = array('errors' => array(array('status'=> AgentApiCode::MESSAGES_UNSUPPORTED_FORMAT)));

    /**
     * @param $ttl
     * @return array
     */
    public static function PASSWORD_ALREADY_REQUESTED($ttl)
    {
        return array('status' => AgentApiCode::PASSWORD_ALREADY_REQUESTED, 'time'  => ($ttl/60));
    }

    /**
     * @param $email
     * @return array
     */
    public static function PASSWORDS_CHANGED_OK_RESPONSE($email)
    {
        return array('status' => AgentApiCode::PASSWORDS_CHANGED_OK, 'email'=> $email);
    }

    /**
     * @param $id
     * @return array
     */
    public static function AGENT_SAVED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'agents', 'id' => $id));
    }



    /**
     * @param Exception $exception
     * @return array
     */
    public static function ERROR_RESPONSE (Exception $exception)
    {
        return array('errors' => array(array('status'=> AgentApiCode::ERROR_MESSAGE, 'detail'=> $exception->getMessage())));
    }

    /** -------- ROLES ---------------------------------------------------------------------------------------------- */
    /**
     * @param $id
     * @return array
     */
    public static function ROLE_SAVED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'roles', 'id' => $id), 'meta' => array('status'=> AgentApiCode::ROLE_SAVED_SUCCESSFULLY));
    }

    /**
     * @param $id
     * @return array
     */
    public static function ROLE_EDITED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'roles', 'id' => $id), 'meta' => array('status'=> AgentApiCode::ROLE_EDITED_SUCCESSFULLY));
    }

    /** -------- GROUPS --------------------------------------------------------------------------------------------- */

    /**
     * @param $id
     * @return array
     */
    public static function GROUP_SAVED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'groups', 'id' => $id), 'meta' => array('status'=> AgentApiCode::GROUP_SAVED_SUCCESSFULLY));
    }

    /**
     * @param $id
     * @return array
     */
    public static function GROUP_EDITED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'groups', 'id' => $id), 'meta' => array('status'=> AgentApiCode::GROUP_EDITED_SUCCESSFULLY));
    }

    /** -------- TICKET --------------------------------------------------------------------------------------------- */

    /**
     * @param $id
     * @return array
     */
    public static function TICKET_SAVED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'tickets', 'id' => $id), 'meta' => array('status'=> AgentApiCode::TICKET_SAVED_SUCCESSFULLY));
    }

}