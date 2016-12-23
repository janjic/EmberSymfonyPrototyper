<?php

namespace UserBundle\Business\Manager\Notification;

use Symfony\Component\HttpFoundation\Request;

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

        $user = $this->getCurrentUser();

        $notifications   = $this->repository->getNotificationsForInfinityScroll($user->getId(), $page, $perPage, $minId, $maxId);

        $totalItems = $this->repository->getNotificationsForInfinityScroll($user->getId(), null, null, null, null, true)[0][1];

        return $this->serializeNotification($notifications, ['total_pages'=>ceil($totalItems / $perPage)]);
    }
}