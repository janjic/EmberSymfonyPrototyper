<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 21.12.16.
 * Time: 14.47
 */

namespace UserBundle\Adapter\Notification;

use CoreBundle\Adapter\JsonAPIConverter;
use UserBundle\Business\Manager\InvitationManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class NotificationApiConverter
 * @package UserBundle\Adapter\Notification
 */
class NotificationApiConverter extends JsonAPIConverter
{
    /**
     * @param InvitationManager $invitationManager
     * @param Request        $request
     * @param string         $param
     */
    public function __construct(InvitationManager $invitationManager, Request $request, $param)
    {
        parent::__construct($invitationManager, $request, $param);
    }

    /**
     * @inheritdoc
     */
    public function convert()
    {
        $this->request->attributes->set($this->param, new ArrayCollection(parent::convert()));
    }
}