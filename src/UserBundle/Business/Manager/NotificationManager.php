<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 21.12.16.
 * Time: 14.21
 */

namespace UserBundle\Business\Manager;


use CoreBundle\Business\Manager\JSONAPIEntityManagerInterface;
use FSerializerBundle\services\FJsonApiSerializer;
use UserBundle\Business\Manager\Notification\JsonApiSaveNotificationManagerTrait;
use UserBundle\Business\Repository\NotificationRepository;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Notification;
use UserBundle\Entity\NotificationType;

/**
 * Class NotificationManager
 * @package UserBundle\Business\Manager
 */
class NotificationManager implements JSONAPIEntityManagerInterface
{

    use JsonApiSaveNotificationManagerTrait;
    public function getResource($id = null){}
    public function deleteResource($id = null){}
    public function updateResource($id = null){}

    /**
     * @var NotificationRepository
     */
    protected $repository;

    /**
     * @var FJsonApiSerializer
     */
    protected $fSerializer;

    /**
     * @param NotificationRepository $repository
     * @param FJsonApiSerializer $fSerializer
     */
    public function __construct(NotificationRepository $repository, FJsonApiSerializer $fSerializer)
    {
        $this->repository = $repository;
        $this->fSerializer = $fSerializer;
    }

    /**
     * @param Notification $notification
     */
    public function execute(Notification $notification)
    {

    }

    /**
     * @param Agent $agent
     * @param Agent|null $superiorAgent
     * @return Notification
     */
    public static function createNewAgentNotification($agent, $superiorAgent = null)
    {
        $superiorAgent = is_null($superiorAgent) ? $agent->getSuperior(): $superiorAgent;
        $notification = new Notification();
        $notification->setType(NotificationType::NEW_AGENT_NOTIFICATION);
        $notification->setNewAgent($agent);
        $notification->setMessage("New agent added");
        $notification->setCreatedAt(new \DateTime());
        $notification->setAgent($superiorAgent);

        return $notification;
    }

    /**
     * @param $agent
     * @param $message
     * @return Notification
     */
    public static function createNewMessageNotification($agent, $message)
    {
        $notification = new Notification();
        $notification->setType(NotificationType::NEW_MESSAGE_NOTIFICATION);
        $notification->setNewAgent(null);
        $notification->setMessage($message);
        $notification->setCreatedAt(new \DateTime());
        $notification->setAgent($agent);

        return $notification;
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function deserializeNotification($content, $mappings = null)
    {
        $relations = array('agent');

        if (!$mappings) {
            $mappings = array(
                'notification'  => array('class' => Notification::class, 'type'=>'notifications'),
                'agent'        => array('class' => Agent::class, 'type' => 'agents')
            );
        }

        return $this->fSerializer->setDeserializationClass(Notification::class)->deserialize($content, $mappings, $relations);
    }

    /**
     * @param $content
     * @param null $mappings
     * @return mixed
     */
    public function serializeNotification($content, $mappings = null)
    {
        $relations = array('agent');

        if (!$mappings) {
            $mappings = array(
                'notification'  => array('class' => Notification::class, 'type'=>'notifications'),
                'agent'        => array('class' => Agent::class, 'type' => 'agents')
            );
        }

        return $this->fSerializer->serialize($content, $mappings, $relations)->toArray();
    }
}