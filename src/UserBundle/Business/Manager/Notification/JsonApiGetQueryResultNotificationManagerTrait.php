<?php

namespace UserBundle\Business\Manager\Notification;

use Symfony\Component\HttpFoundation\Request;
use UserBundle\Helpers\NotificationHelper;

/**
 * Class JsonApiGetQueryResultNotificationManagerTrait
 * @package UserBundle\Business\Manager\Notification
 */
trait JsonApiGetQueryResultNotificationManagerTrait
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getQueryResult($request)
    {
        $page       = ($p = $request->query->get('page')) ? $p : 1;
        $perPage    = $request->query->get('per_page');
        $minId      = $request->query->get('min_id');
        $maxId      = $request->query->get('max_id');
        $type       = $request->query->get('type');

        $user = $this->getCurrentUser();

        if( $type == NotificationHelper::NOTIFICATION_AGENT_PAYMENT ){
            $type = in_array(NotificationHelper::OPTION_AGENT, $user->getNotifications()) ? NotificationHelper::NOTIFICATION_AGENT : '';
            if ( in_array(NotificationHelper::OPTION_PAYMENT, $user->getNotifications()) ){
                $type = $type ? NotificationHelper::NOTIFICATION_AGENT_PAYMENT: NotificationHelper::NOTIFICATION_PAYMENT;
            }
        }

        $notifications   = $this->repository->getNotificationsForInfinityScroll($user->getId(), $page, $perPage, $minId, $maxId, $type);

        $totalItems = $this->repository->getNotificationsForInfinityScroll($user->getId(), null, null, null, null, $type, true)[0][1];

        return $this->serializeNotification($notifications, ['total_pages'=>ceil($totalItems / $perPage)]);
    }
}