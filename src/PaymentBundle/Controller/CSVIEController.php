<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CSVIEController extends Controller
{
    /**
     * @Route("/api/csv/payment", name="payments_csv", options={"expose" = true})
     * @param ArrayCollection $paymentInfoCSV
     * @return Response
     */
    public function convertToCSVPaymentAction(ArrayCollection $paymentInfoCSV)
    {
        $response = new Response();
        $response->headers->set('Content-type', 'application/octect-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', "export.csv"));
        $response->headers->set('Content-Transfer-Encoding', 'binary');

        $response->setContent($paymentInfoCSV[0]);

        return $response;
    }
}
