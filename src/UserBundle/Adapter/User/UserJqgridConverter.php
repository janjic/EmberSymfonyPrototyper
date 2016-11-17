<?php

namespace UserBundle\Adapter\User;


use CoreBundle\Adapter\JQGridConverter;
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Business\Manager\UserManager;

/**
 * Class UserJQGRIDListConverter
 *
 * @package Alligator\Adapter\User
 */
class UserJqgridConverter extends JQGridConverter
{
    /**
     * @param UserManager $manager
     * @param Request     $request
     * @param string      $param
     */
    public function __construct(UserManager $manager, Request $request, $param)
    {
        parent::__construct($manager, $request, $param);
        $this->searchFields = array('id'=>'user.id', 'username'=>'user.username', 'firstName'=>'user.firstName',
            'lastName'=>'user.lastName', 'city'=>'a.city', 'country'=>'a.country', 'type'=>'user.type', 'enabled'=>'user.enabled',
            'locked'=>'user.locked', 'numOfSuccessOrders' => 'numOfSuccessOrders', 'numOfOrders' => 'numOfOrders');
    }

    /**
     * @return mixed
     */
    public function convert()
    {

        return parent::convert();
    }
}