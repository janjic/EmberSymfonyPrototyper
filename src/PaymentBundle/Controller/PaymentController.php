<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Util\Debug;

class PaymentController extends Controller
{
    /**
     * @Route("/test_payment")
     */
    public function indexAction()
    {
        $payments = $this->get('agent_system.payment_info.manager')->calculateCommissions(121, 10, 10, 10, 10);

        Debug::dump($payments);
        die('asddd');
    }
}
