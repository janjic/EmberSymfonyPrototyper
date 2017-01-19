<?php

namespace PaymentBundle\Controller;

use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Agent;

class PaymentController extends Controller
{
    /**
     * @Route("api/payment/test_payment", name="test_payment", options={"expose" = true})
     * @param Request $request
     * @return JsonResponse
     */
    public function testAction(Request $request)
    {
        $payments = $this->get('agent_system.payment_info.manager')->calculateCommissions(
            (int) $request->request->get('agentId'),
            (float) $request->request->get('sumPackages'),
            (float) $request->request->get('sumConnection'),
            (float) $request->request->get('sumOneTimeSetupFee'),
            (float) $request->request->get('sumStreams'),
            (int) $request->request->get('customerId'),
            (int) $request->request->get('orderId'),
            $request->request->get('currency'),
            json_decode($request->request->get('customersInAYear')),
            false
        );

        return new JSONResponse($payments);
    }

    /**
     * @Route("/api/payment/process_payment", name="process_payment", options={"expose" = true})
     * @param ArrayCollection $paymentInfoCreate
     * @return JsonResponse
     * @internal param Request $request
     */
    public function processPaymentAction(ArrayCollection $paymentInfoCreate)
    {
        return new JSONResponse($paymentInfoCreate->toArray());
    }

    /**
     * @Route("/api/payment-infos/{id}", name="api_payment_infos", options={"expose" = true}, defaults={"id": "all"})
     * @param ArrayCollection $paymentInfoAPI
     * @return JSONResponse
     */
    public function paymentAPIAction(ArrayCollection $paymentInfoAPI)
    {
        return new JSONResponse($paymentInfoAPI->toArray(), array_key_exists('errors', $paymentInfoAPI->toArray()) ? 422 : 200);
    }

    /**
     * @Route("/api/payment/execute-payment", name="api_execute_payment", options={"expose" = true})
     * @param ArrayCollection $paymentInfoExecutePayment
     * @return JSONResponse
     */
    public function executePaymentAction(ArrayCollection $paymentInfoExecutePayment)
    {
        return new JSONResponse($paymentInfoExecutePayment->toArray(), array_key_exists('errors', $paymentInfoExecutePayment->toArray()) ? 422 : 200);
    }

    /**
     * @Route("/api/payment/earnings-by-agent", name="api_earnings_by_agent", options={"expose" = true})
     * @param ArrayCollection $paymentInfoEarningsByAgent
     * @return JSONResponse
     */
    public function earningsByAgentAction(ArrayCollection $paymentInfoEarningsByAgent)
    {
        return new JSONResponse($paymentInfoEarningsByAgent->toArray(), array_key_exists('errors', $paymentInfoEarningsByAgent->toArray()) ? 422 : 200);
    }

    /** ----------- ORDERS -------------------------------------------------------------------------------------------*/

    /**
     * @Route("/api/order-print/{id}", name="order_print", options={"expose" = true})
     * @param Request $request
     * @return string
     */
    public function orderPrintAction(Request $request)
    {
        $pdfGenerator = $this->get('agent.system.pdf.generator');

        $tcrManager = $this->get('agent_system.tcr_user_manager');

        $url = 'en/orders/order-preview-complete/'.$request->get('id');

        $settingsData = $this->get('agent_system.settings.manager')->getResource();

        $imageUrl = '';

        foreach ($settingsData['included'] as $inc) {
            if ($inc['type'] == 'images'){
                $imageUrl = $inc['attributes']['absolutePathWithVersion'];
                break;
            }
        }

        $response = $tcrManager->getContentFromTCR($url, 'GET');

        $html = $this->renderView('@Payment/invoice-pdf.html.twig', array('order' => $response->{0}, 'logo' => $imageUrl));

        $invoiceDir = '/var/www/fsd_dev/web/uploads/documents/';
        $file = $pdfGenerator->saveToFile($invoiceDir.'order-'.$response->{0}->id.'.pdf', 'S', $html);

        $encoded = base64_encode($file);
        $encoded = chunk_split($encoded, 76, "\r\n");

        return new Response('data:application/pdf;base64,' . $encoded);
    }

    /**
     * @Route("/api/payment/commission-by-agent/", name="commission-by-agent", options={"expose" = true})
     * @param ArrayCollection $commissionsByAgent
     * @return string
     */
    public function commissionsByAgentAction(ArrayCollection $commissionsByAgent)
    {
        return new JSONResponse($commissionsByAgent->toArray(), array_key_exists('errors', $commissionsByAgent->toArray()) ? 422 : 200);

    }

    /**
     * @Route("/api/payment/bonuses-by-agent/", name="bonuses-by-agent", options={"expose" = true})
     * @param ArrayCollection $bonusesByAgent
     * @return string
     */
    public function bonusesByAgentAction(ArrayCollection $bonusesByAgent)
    {
        return new JSONResponse($bonusesByAgent->toArray(), array_key_exists('errors', $bonusesByAgent->toArray()) ? 422 : 200);

    }

    /**
     * @Route("/api/newPaymentsInfo" ,name="new-payments-info",
     * options={"expose" = true})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNewPaymentsInfoAction()
    {
        $superAdminId       = $this->get('agent_system.agent.repository')->findAgentByRole()->getId();

        $newCommissionsInfo = $this->get('agent_system.payment_info.manager')->newCommissionsCount($superAdminId);

        return new JsonResponse(AgentApiResponse::NEW_PAYMENTS_INFO_OK_RESPONSE($newCommissionsInfo));
    }
}
