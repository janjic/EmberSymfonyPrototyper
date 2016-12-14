<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 13.12.16.
 * Time: 12.01
 */

namespace UserBundle\Business\Manager;


use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\Invitation\JsonApiSaveInvitationManagerTrait;
use UserBundle\Business\Repository\InvitationRepository;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Invitation;

class InvitationManager implements JSONAPIEntityManagerInterface
{

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
     * @param InvitationRepository $repository
     * @param FJsonApiSerializer $fSerializer
     * @param \Swift_Mailer $mailer
     */
    public function __construct(InvitationRepository $repository, FJsonApiSerializer $fSerializer, \Swift_Mailer $mailer)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
        $this->mailer = $mailer;
    }

    /**
     * @param Invitation $invitation
     */
    public function sendMail(Invitation $invitation)
    {
        $subject = $invitation->getEmailSubject();
        $from = $invitation->getAgent()->getEmail();
        $body = $invitation->getEmailContent();

        /** @var \Swift_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setBody($body, 'text/html');

        foreach ($invitation->getRecipientEmail() as $recipient){
            $message->setTo($recipient);
            $this->mailer->send($message);
        }
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