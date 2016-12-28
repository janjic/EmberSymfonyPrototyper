<?php

namespace UserBundle\Adapter\Notification;

use CoreBundle\Adapter\JsonAPIConverter;
use UserBundle\Business\Manager\InvitationManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Business\Manager\NotificationManager;

/**
 * Class NotificationAPIConverter
 * @package UserBundle\Adapter\Notification
 */
class NotificationAPIConverter extends JsonAPIConverter
{
    /**
     * @param NotificationManager $notificationManager
     * @param Request        $request
     * @param string         $param
     */
    public function __construct(NotificationManager $notificationManager, Request $request, $param)
    {
        parent::__construct($notificationManager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, new ArrayCollection(parent::convert()));
    }
}