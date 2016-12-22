<?php

namespace UserBundle\Business\Manager\Notification;

use CoreBundle\Adapter\AgentApiResponse;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Notification;
use Exception;

/**
 * Class JsonApiSaveNotificationManagerTrait
 * @package UserBundle\Business\Manager\Notification
 */
trait JsonApiSaveNotificationManagerTrait
{
    /**
     * @param string $data
     * @return mixed
     */
    public function saveResource($data)
    {
        $this->repository->saveNotification($data);
        /** @var Notification $notification */
//        $notification = $this->deserializeNotification($data);

       // $notification->setAgent($this->repository->getReferenceForClass($notification->getAgent()->getId(), Agent::class));

//        return $this->createJsonAPiSaveResponse($this->repository->saveNotification($data));
    }

    /**
     * @param $data
     * @return mixed
     */
    private function createJsonAPiSaveResponse($data)
    {
        switch (get_class($data)) {
            case Exception::class:
                return AgentApiResponse::ERROR_RESPONSE($data);
            case (Notification::class && ($id = $data->getId())):
                return AgentApiResponse::INVITATION_SAVED_SUCCESSFULLY($id);
            default:
                return false;
        }
    }
}