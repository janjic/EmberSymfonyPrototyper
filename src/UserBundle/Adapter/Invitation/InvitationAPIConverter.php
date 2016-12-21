<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 13.12.16.
 * Time: 12.51
 */

namespace UserBundle\Adapter\Invitation;

use CoreBundle\Adapter\JsonAPIConverter;
use UserBundle\Business\Manager\InvitationManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class InvitationAPIConverter
 * @package UserBundle\Adapter\Invitation
 */
class InvitationAPIConverter extends JsonAPIConverter
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