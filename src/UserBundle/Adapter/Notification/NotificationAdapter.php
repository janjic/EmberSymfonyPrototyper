<?php

namespace UserBundle\Adapter\Notification;

use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use UserBundle\Business\Manager\NotificationManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NotificationAdapter
 * @package UserBundle\Adapter\Notification
 */
class NotificationAdapter extends BaseAdapter
{
    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @param NotificationManager $notificationManager
     */
    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager= $notificationManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).NotificationAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->notificationManager, $request, $param);
    }
}