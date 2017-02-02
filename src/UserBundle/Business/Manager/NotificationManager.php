<?php

namespace UserBundle\Business\Manager;


use ConversationBundle\Business\Event\Thread\ThreadReadEvent;
use ConversationBundle\Business\Manager\MessageManager;
use ConversationBundle\Entity\Message;
use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use PaymentBundle\Entity\PaymentInfo;
use UserBundle\Business\Event\Notification\NotificationEvent;
use UserBundle\Business\Manager\Notification\JsonApiGetQueryResultNotificationManagerTrait;
use UserBundle\Business\Manager\Notification\JsonApiSaveNotificationManagerTrait;
use UserBundle\Business\Manager\Notification\JsonApiUpdateNotificationManagerTrait;
use UserBundle\Business\Repository\NotificationRepository;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Notification;
use UserBundle\Entity\NotificationType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Helpers\NotificationHelper;

/**
 * Class NotificationManager
 * @package UserBundle\Business\Manager
 */
class NotificationManager implements JSONAPIEntityManagerInterface
{

    use JsonApiSaveNotificationManagerTrait;
    use JsonApiGetQueryResultNotificationManagerTrait;
    public function getResource($id = null){}
    public function deleteResource($id = null){}
    use JsonApiUpdateNotificationManagerTrait;

    /**
     * @var NotificationRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @var MessageManager
     */
    protected $messageManager;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @param NotificationRepository $repository
     * @param MessageManager $messageManager
     * @param FJsonApiSerializer $fSerializer
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(NotificationRepository $repository, MessageManager $messageManager,
                                FJsonApiSerializer $fSerializer, TokenStorageInterface $tokenStorage)
    {
        $this->repository       = $repository;
        $this->messageManager   = $messageManager;
        $this->fSerializer      = $fSerializer;
        $this->tokenStorage     = $tokenStorage;
    }

    /**
     * @param Notification $notification
     */
    public function execute(Notification $notification)
    {

    }

    /**
     * @return mixed
     */
    public function getCurrentUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * @param Agent $agent
     * @param Agent|null $superiorAgent
     * @param mixed $isSuperAdmin
     * @return Notification
     */
    public static function createNewAgentNotification($agent, $superiorAgent = null, $isSuperAdmin = false)
    {
        $superiorAgent = is_null($superiorAgent) ? $agent->getSuperior(): $superiorAgent;
        $notification = new Notification();
        $notification->setType(NotificationHelper::NOTIFICATION_AGENT);
        $notification->setNewAgent($agent);

        if( $isSuperAdmin ) {
            $notification->setLink('dashboard.agents.agent-view');
        } else {
            $notification->setLink('dashboard.agent.agents.agent-view');
        }

        $notification->setCreatedAt(new \DateTime());
        $notification->setAgent($superiorAgent);

        return $notification;
    }

    /**
     * @param Message $message
     * @param mixed $isSuperAdmin
     * @return Notification
     */
    public static function createNewMessageNotification($message, $isSuperAdmin = false)
    {
        $notification = new Notification();
        $notification->setType(NotificationHelper::NOTIFICATION_MESSAGE);
        $notification->setNewAgent(null);
        if( $isSuperAdmin ) {
            $notification->setLink('dashboard.messages.received-messages');
        } else {
            $notification->setLink('dashboard.agent.messages.received-messages');
        }
        $notification->setMessage($message);
        $notification->setCreatedAt(new \DateTime());

        return $notification;
    }

    public function createNewPaymentNotification($agent, $payment)
    {
        $notification = new Notification();
        $notification->setType(NotificationHelper::NOTIFICATION_PAYMENT);
        $notification->setPayment($payment);
        $notification->setAgent($agent);
        if( in_array(RoleManager::ROLE_SUPER_ADMIN, $agent->getRoles()) ) {
            $notification->setLink('dashboard.payments.payouts-to-agents');
        } else {
            $notification->setLink('dashboard.agent.wallet.payout-history');
        }
        $notification->setCreatedAt(new \DateTime());

        $this->repository->saveNotification([$notification]);
    }

    public function saveNotifications(NotificationEvent $event)
    {
        /** @var Message $message */
        if( $message = $event->getMessage() ) {

            $user = $this->getCurrentUser();

            $agentRecipient = $message->getParticipantsFromMeta()[0]->getId() == $user->getId() ?
                $message->getParticipantsFromMeta()[1] : $message->getParticipantsFromMeta()[0];

            foreach ($event->getNotifications() as $notification) {
                $superAdmin = in_array(RoleManager::ROLE_SUPER_ADMIN, $agentRecipient->getRoles());
                if( $superAdmin ) {
                    $notification->setLink('dashboard.messages.received-messages');
                } else {
                    $notification->setLink('dashboard.agent.messages.received-messages');
                }
                $notification->setAgent($agentRecipient);
            }
        }

        $this->repository->saveNotification($event->getNotifications());
    }

    public function updateNotificationsToSeen(ThreadReadEvent $event)
    {
        $user = $this->getCurrentUser();

        $this->repository->updateNotificationsToSeen($event->getThread(), $user);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeNotification($content, $mappings = null)
    {
        $relations = array('agent', 'newAgent');

        if (!$mappings) {
            $mappings = array(
                'notification'  => array('class' => Notification::class, 'type'=>'notifications'),
                'agent'         => array('class' => Agent::class, 'type' => 'agents'),
                'newAgent'      => array('class' => Agent::class, 'type' => 'agents')
            );
        }

        return $this->fSerializer->setDeserializationClass(Notification::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param $metaTags
     * @param null $mappings
     * @return mixed
     */
    public function serializeNotification($content, $metaTags = [], $mappings = null)
    {
        $relations = array('agent', 'newAgent', 'payment');

        if (!$mappings) {
            $mappings = array(
                'notification'  => array('class' => Notification::class, 'type'=>'notifications'),
                'agent'         => array('class' => Agent::class, 'type' => 'agents'),
                'newAgent'      => array('class' => Agent::class, 'type' => 'agents'),
                'payment'       => array('class' => PaymentInfo::class, 'type' => 'payment-infos')
            );
        }
        $serialize = $this->fSerializer->serialize($content, $mappings, $relations, array(), AgentSerializerInfo::$basicFields);

        foreach ($metaTags as $key=>$meta) {
            $serialize->addMeta($key, $meta);
        }

        return $serialize->toArray();
    }
}