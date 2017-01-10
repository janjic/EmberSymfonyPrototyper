<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/order-print/{id}")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function orderPrintAction(Request $request)
    {
        $pdfGenerator = $this->get('agent.system.pdf.generator');

        $tcrManager = $this->get('agent_system.tcr_user_manager');

        $url = 'en/orders/order-preview-complete/'.$request->get('id');

        $settingsData = $this->get('agent_system.settings.manager')->getResource();

        $imageUrl = '';
//        var_dump($settingsData['included']);exit;
        foreach ($settingsData['included'] as $inc) {
            if ($inc['type'] == 'images'){
                $imageUrl = $inc['attributes']['absolutePathWithVersion'];
                break;
            }
        }
        $response = $tcrManager->getContentFromTCR($url, 'GET');

        $html = $this->renderView('@Payment/invoice-pdf.html.twig', array('order' => $response->{0}, 'logo' => $imageUrl));

        $invoiceDir = '/var/www/fsd_dev/web/uploads/documents/';
        $file = $pdfGenerator->saveToFile($invoiceDir.'fajl.pdf', 'S', $html);

        $encoded = base64_encode($file);
        $encoded = chunk_split($encoded, 76, "\r\n");

        var_dump('data:application/pdf;base64,' . $encoded);exit;

        return ($response = $pdfGenerator->generatePdfResponse($html));

    }
}
