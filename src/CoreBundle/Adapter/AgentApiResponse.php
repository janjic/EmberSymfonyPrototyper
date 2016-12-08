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
        return array('data' => array('type'=> 'agents', 'id' => $id), 'meta' => array('status'=> AgentApiCode::AGENT_SAVED_SUCCESSFULLY));
    }


    /**
     * @param Exception $exception
     * @return array
     */
    public static function ERROR_RESPONSE (Exception $exception)
    {
        return array('status' => AgentApiCode::ERROR_MESSAGE, 'message'=> $exception->getMessage());
    }



}