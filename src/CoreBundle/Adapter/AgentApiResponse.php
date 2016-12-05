<?php

namespace CoreBundle\Adapter;

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



    /**
     * @param $ttl
     * @return array
     */
    public static function PASSWORD_ALREADY_REQUESTED($ttl){
        return array('status' => AgentApiCode::PASSWORD_ALREADY_REQUESTED, 'time'  => ($ttl/60));
    }

    /**
     * @param $email
     * @return array
     */
    public static function PASSWORDS_CHANGED_OK_RESPONSE($email){
        return array('status' => AgentApiCode::PASSWORDS_CHANGED_OK, 'email'=> $email);
    }



}