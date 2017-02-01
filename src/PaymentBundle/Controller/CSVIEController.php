<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CSVIEController extends Controller
{
    /**
     * @Route("/test/csv/payment", name="payments_csv", options={"expose" = true})
     * @return Response
     */
    public function convertToCSVPaymentAction()
    {
        $manager = $this->get('agent_system.payment_info.manager');

        $response = new Response();
        $response->headers->set('Content-type', 'application/octect-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', "export.csv"));
        $response->headers->set('Content-Transfer-Encoding', 'binary');

        $response->setContent($manager->exportToCSV());

        return $response;
    }
}
