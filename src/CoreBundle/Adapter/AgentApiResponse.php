<?php

namespace CoreBundle\Adapter;
use Exception;

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
    const AGENT_SYNC_ERROR_RESPONSE             = array('errors' => array(array('status'=> AgentApiCode::AGENT_SYNC_ERROR)));
    const AGENT_DELETED_SUCCESSFULLY            = array('meta' => array('status'=> AgentApiCode::AGENT_DELETED_SUCCESSFULLY));

    const ROLE_DELETED_SUCCESSFULLY             = array('meta' => array('status'=> AgentApiCode::ROLE_EDITED_SUCCESSFULLY));
    const ROLE_ALREADY_EXIST                    = array('errors' => array(array('status'=> AgentApiCode::ROLE_ALREADY_EXIST)));

    const GROUP_DELETED_SUCCESSFULLY            = array('meta' => array('status'=> AgentApiCode::GROUP_EDITED_SUCCESSFULLY));
    const GROUP_CHANGE_FOR_USERS_FAILED         = array('errors' => array(array('status'=> AgentApiCode::GROUP_CHANGE_FOR_USERS_FAILED)));
    const GROUP_ALREADY_EXIST                   = array('errors' => array(array('status'=> AgentApiCode::GROUP_ALREADY_EXIST)));

    const TICKET_NOT_FOUND_RESPONSE             = array('status' => AgentApiCode::TICKET_NOT_FOUND);
    const AGENT_INACTIVE_RESPONSE               = array('status' => AgentApiCode::AGENT_CURRENTLY_INACTIVE);
    const ACCESS_TO_TICKET_DENIED               = array('errors' => array(array('status' => AgentApiCode::ACCESS_DENIED)));
    const TICKET_THREAD_NOT_SAVED               = array('errors' => array(array('status' => AgentApiCode::TICKET_THREAD_NOT_SAVED)));


    const MESSAGES_UNSUPPORTED_FORMAT           = array('errors' => array(array('status'=> AgentApiCode::MESSAGES_UNSUPPORTED_FORMAT)));
    const MESSAGES_DRAFT_ERROR                  = array('errors' => array(array('status'=> AgentApiCode::MESSAGES_DRAFT_ERROR)));

    const PAYMENT_EXECUTE_ERROR                 = array('errors' => array(array('status'=> AgentApiCode::PAYMENT_EXECUTE_ERROR)));

    const PAYMENT_EXECUTE_ALL_SUCCESS           = array('meta' => array('status'=> AgentApiCode::PAYMENT_EXECUTE_ALL_SUCCESS));

    /**
     * @param $ttl
     * @return array
     */
    public static function PASSWORD_ALREADY_REQUESTED($ttl)
    {
        return array('status' => AgentApiCode::PASSWORD_ALREADY_REQUESTED, 'time'  => ($ttl/60));
    }

    /**
     * @param $childCount
     * @param $numberOfUsers
     * @return array
     */
    public static function AGENT_INFO_OK_RESPONSE($childCount, $numberOfUsers)
    {
        return array('data' => array('childCount'=> $childCount, 'usersCount' => $numberOfUsers), 'status' => AgentApiCode::AGENT_INFO_CALCULATED_OK);
    }

    /**
     * @param $info
     * @return array
     */
    public static function NEW_AGENTS_INFO_OK_RESPONSE($info)
    {
        return array('data' => $info, 'status' => AgentApiCode::AGENT_NEW_INFO_OK);
    }
    /**
     * @param $info
     * @return array
     */
    public static function CHECK_NEW_SUPERIOR_TYPE($info)
    {
        return array('data' => $info, 'status' => AgentApiCode::AGENT_NEW_SUPERIOR_RESPONSE);
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
     * @param $exception
     * @return array
     */
    public static function AGENT_DELETE_ERROR($exception)
    {
        return array('errors' => array(array('status'=> AgentApiCode::AGENT_DELETE_ERROR, 'detail'=> $exception->getMessage())));
    }

    /**
     * @param $message
     * @return array
     */
    public static function AGENT_DELETE_SYNC_ERROR($message)
    {
        return array('errors' => array(array('status'=> AgentApiCode::AGENT_DELETE_SYNC_ERROR, 'detail'=> $message)));
    }

    /**
     * @param $exception
     * @return array
     */
    public static function AGENT_PARENT_CHANGE_ERROR_RESPONSE($exception)
    {
        return array('errors' => array(array('status'=> AgentApiCode::AGENT_PARENT_CHANGE_ERROR_RESPONSE, 'detail'=> $exception->getMessage())));
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

    /** -------- THREAD --------------------------------------------------------------------------------------------- */
    /**
     * @param $id
     * @return array
     */
    public static function THREAD_EDITED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'threads', 'id' => $id), 'meta' => array('status'=> AgentApiCode::THREAD_EDITED_SUCCESSFULLY));
    }

    /**
     * @param $id
     * @return array
     */
    public static function MAIL_LIST_SAVED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'mailLists', 'id' => $id), 'meta' => array('status'=> AgentApiCode::MAIL_LIST_SAVED_SUCCESSFULLY));
    }

    /**
     * @param $id
     * @return array
     */
    public static function MAIL_CAMPAIGN_SAVED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'mail-campaigns', 'id' => $id), 'meta' => array('status'=> AgentApiCode::MAIL_CAMPAIGN_SAVED_SUCCESSFULLY));
    }


    /** -------- INVITATION ----------------------------------------------------------------------------------------- */
    /**
     * @param $id
     * @return array
     */
    public static function INVITATION_SAVED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'invitations', 'id' => $id), 'meta' => array('status'=> AgentApiCode::INVITATION_SAVED_SUCCESSFULLY));
    }

    /** -------- SETTINGS ------------------------------------------------------------------------------------------- */
    /**
     * @param $id
     * @return array
     */
    public static function SETTINGS_SAVED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'settings', 'id' => $id), 'meta' => array('status'=> AgentApiCode::SETTINGS_SAVED_SUCCESSFULLY));
    }

    /**
     * @param $id
     * @return array
     */
    public static function SETTINGS_EDITED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'SETTINGS', 'id' => $id), 'meta' => array('status'=> AgentApiCode::GROUP_EDITED_SUCCESSFULLY));
    }

    /** -------- NOTIFICATIONS -------------------------------------------------------------------------------------- */
    /**
     * @param $id
     * @return array
     */
    public static function NOTIFICATION_EDITED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'notifications', 'id' => $id), 'meta' => array('status'=> AgentApiCode::NOTIFICATION_EDITED_SUCCESSFULLY));
    }

    /** -------- PAYMENT INFO --------------------------------------------------------------------------------------- */
    /**
     * @param $id
     * @return array
     */
    public static function PAYMENT_EXECUTED_SUCCESSFULLY($id)
    {
        return array('data' => array('type'=> 'payment-infos', 'id' => $id), 'meta' => array('status'=> AgentApiCode::PAYMENT_EXECUTED_SUCCESSFULLY));
    }

    /**
     * @param $info
     * @return array
     */
    public static function NEW_PAYMENTS_INFO_OK_RESPONSE($info)
    {
        return array('data' => $info, 'status' => AgentApiCode::PAYMENT_NEW_INFO_OK);
    }

    /**
     * @param $exception
     * @return array
     */
    public static function PAYMENT_EXECUTE_ALL_ERROR($exception)
    {
        return array('errors' => array(array('status'=> AgentApiCode::PAYMENT_EXECUTE_ALL_ERROR, 'detail'=> $exception->getMessage())));
    }

}