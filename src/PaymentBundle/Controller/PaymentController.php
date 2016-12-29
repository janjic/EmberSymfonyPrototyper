<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PaymentController extends Controller
{
    /**
     * @Route("/test_payment")
     */
    public function indexAction()
    {
        $this->get('agent_system.payment_info.manager')->calculateCommissions(111, 10, 10, 10, 10);

        die('asddd');
    }
}
