<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 13.12.16.
 * Time: 12.44
 */

namespace UserBundle\Adapter\Invitation;


use CoreBundle\Adapter\BaseAdapter;
use CoreBundle\Adapter\BasicConverter;
use UserBundle\Business\Manager\InvitationManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class InvitationAdapter
 * @package UserBundle\Adapter\Invitation
 */
class InvitationAdapter extends BaseAdapter
{
    /**
     * @var InvitationManager
     */
    private $invitationManager;

    /**
     * @param InvitationManager $invitationManager
     */
    public function __construct(InvitationManager $invitationManager)
    {
        $this->invitationManager= $invitationManager;
    }

    /**
     * @param string  $param
     * @param Request $request
     * @return BasicConverter
     */
    public function buildConverterInstance($param, Request $request)
    {
        $type = __NAMESPACE__."\\".ucfirst($param).InvitationAdapterUtil::BASE_CONVERTER_NAME;

        return new $type($this->invitationManager, $request, $param);
    }
}