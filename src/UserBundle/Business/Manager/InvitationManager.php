<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 13.12.16.
 * Time: 12.01
 */

namespace UserBundle\Business\Manager;


use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use Exception;
use FSerializerBundle\services\FJsonApiSerializer;
use MailCampaignBundle\Business\Manager\MailCampaign\MailCampaignManager;
use MailCampaignBundle\Util\MailChimp;
use UserBundle\Business\Manager\Invitation\JsonApiSaveInvitationManagerTrait;
use UserBundle\Business\Repository\InvitationRepository;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Invitation;
use UserBundle\Entity\Settings\Settings;

/**
 * Class InvitationManager
 * @package UserBundle\Business\Manager
 */
class InvitationManager implements JSONAPIEntityManagerInterface
{

    const INVITATION_MAIL_SUBJECT     = 'Invite';
    const INVITATION_MAIL_TEMPLATE_ID = 58635;

    use JsonApiSaveInvitationManagerTrait;
    public function getResource($id = null){}
    public function deleteResource($id = null){}
    public function updateResource($id = null){}

    /**
     * @var InvitationRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Mailchimp
     */
    protected $mailChimp;

    /**
     * @var SettingsManager
     */
    protected $settingsManager;

    /**
     * @param InvitationRepository $repository
     * @param FJsonApiSerializer $fSerializer
     * @param \Swift_Mailer $mailer
     * @param SettingsManager $settingsManager
     */
    public function __construct(InvitationRepository $repository, FJsonApiSerializer $fSerializer, \Swift_Mailer $mailer, SettingsManager $settingsManager)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
        $this->mailer = $mailer;
        $this->mailChimp = new Mailchimp(MailCampaignManager::MAIL_CHIMP_API);
        $this->settingsManager = $settingsManager;
    }


    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settingsManager->getEntity();
    }

    /**
     * @param Invitation $invitation
     * @return array|Exception|false
     */
    public function sendMail(Invitation $invitation)
    {
        /**
         * @var $settings Settings
         */
        $settings = $this->getSettings();
        $campaign = $this->mailChimp->post('campaigns', [
            'recipients' => [
                'list_id'=> $invitation->getMailList()
            ],
            'type' => 'regular',
            'settings' => [
                'subject_line' => self::INVITATION_MAIL_SUBJECT,
//                'reply_to'    => $invitation->getAgent()->getUsername(),
                'reply_to'    => $settings->getConfirmationMail(),
                'from_name'    => $invitation->getAgent()->getFirstName().''.$invitation->getAgent()->getLastName()
            ]
        ]);
        if($this->mailChimp->success()){
            $template = $this->mailChimp->put('campaigns/'.$campaign['id'].'/content',[
                'template' => [
                    'id' => self::INVITATION_MAIL_TEMPLATE_ID
                ]
            ]);

            if($this->mailChimp->success()) {
                $sendAction = $this->mailChimp->post('campaigns/'.$campaign['id'].'/actions/send');
                if($this->mailChimp->success()) {
                    return $campaign;
                } else {
                    return new Exception($this->mailChimp->getLastError());
                }
            }
            else {
                $exception = new Exception($this->mailChimp->getLastError());

                $this->mailChimp->delete('campaigns/'.$campaign['id']);

                return $exception;
            }
        }
        else {
            return new Exception($this->mailChimp->getLastError());
        }
//        $subject = $invitation->getEmailSubject();
//        $from = $invitation->getAgent()->getEmail();
//        $body = $invitation->getEmailContent();
//
//        /** @var \Swift_Message $message */
//        $message = \Swift_Message::newInstance()
//            ->setSubject($subject)
//            ->setFrom($from)
//            ->setBody($body, 'text/html');
//
//        foreach ($invitation->getRecipientEmail() as $recipient){
//            $message->setTo($recipient);
//            $this->mailer->send($message);
//        }
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeInvitation($content, $mappings = null)
    {
        $relations = array('agent');

        if (!$mappings) {
            $mappings = array(
                'invitations'  => array('class' => Invitation::class, 'type'=>'invitations'),
                'agent'        => array('class' => Agent::class, 'type' => 'agents')
            );
        }

        return $this->fSerializer->setDeserializationClass(Invitation::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function serializeInvitation($content, $mappings = null)
    {
        $relations = array('agent');

        if (!$mappings) {
            $mappings = array(
                'invitations'  => array('class' => Invitation::class, 'type'=>'invitations'),
                'agent'        => array('class' => Agent::class, 'type' => 'agents')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
    }
}