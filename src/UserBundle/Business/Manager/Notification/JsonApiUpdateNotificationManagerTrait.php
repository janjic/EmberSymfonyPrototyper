<?php

namespace UserBundle\Business\Manager\Notification;
use CoreBundle\Adapter\AgentApiResponse;
use Exception;
use UserBundle\Entity\Notification;

/**
 * Class JsonApiSaveNotificationManagerTrait
 * @package UserBundle\Business\Manager\Notification
 */
trait JsonApiUpdateNotificationManagerTrait
{
    /**
     * @param string $data
     * @return mixed
     */
    public function updateResource($data)
    {
        /** @var Notification $notification */
        $notification = $this->deserializeNotification($data);

        /** @var Notification $db_notification */
        $db_notification = $this->repository->find($notification->getId());
        $db_notification->setIsSeen(true);

        return $this->createJsonAPiUpdateResponse($this->repository->editNotification($db_notification));
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiUpdateResponse($data)
    {
        switch (get_class($data)) {
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Notification::class && ($id = $data->getId())):
                return AgentApiResponse::NOTIFICATION_EDITED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }
}