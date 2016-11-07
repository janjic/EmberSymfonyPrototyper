<?php

namespace UserBundle\Adapter;


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
        $this->searchFields = array('id'=>'u.id', 'username'=>'u.username', 'firstName'=>'u.firstName',
            'lastName'=>'u.lastName', 'city'=>'a.city', 'country'=>'a.country', 'type'=>'u.type', 'enabled'=>'u.enabled',
            'locked'=>'u.locked', 'numOfSuccessOrders' => 'numOfSuccessOrders', 'numOfOrders' => 'numOfOrders');
    }

    /**
     * @return mixed
     */
    public function convert()
    {

        return parent::convert();

    }
}