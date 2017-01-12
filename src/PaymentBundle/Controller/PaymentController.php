<?php

namespace PaymentBundle\Controller;

use PaymentBundle\Entity\PaymentInfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Util\Debug;
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
    public function indexAction(Request $request)
    {
        $payments = $this->get('agent_system.payment_info.manager')->calculateCommissions(
            (int) $request->request->get('agentId'),
            (float) $request->request->get('sumPackages'),
            (float) $request->request->get('sumConnection'),
            (float) $request->request->get('sumOneTimeSetupFee'),
            (float) $request->request->get('sumStreams')
        );

        return new JSONResponse($payments);
    }

    /**
     * @Route("/api/order-print/{id}")
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
     * @Route("/api/payment/newPaymentsInfo/{id}" ,name="new-payments-info",
     * options={"expose" = true})
     * @ParamConverter("agent", class="UserBundle:Agent")
     * @param Agent $agent
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNewAgentsInfoAction(Agent $agent)
    {
        $agent = $this->get('agent_system.agent.repository')->findAgentByRole()->getId()==$agent->getId() ? null : $agent;

        $newCommissionsTodayEUR         = $this->get('agent_system.payment_info.manager')->newCommissionsCount($agent, 'today');
        $newCommissionsThisMonthEUR     = $this->get('agent_system.payment_info.manager')->newCommissionsCount($agent, 'month');
        $newCommissionsTotalEUR         = $this->get('agent_system.payment_info.manager')->newCommissionsCount($agent, 'total');

//        return new JsonResponse(AgentApiResponse::NEW_AGENTS_INFO_OK_RESPONSE($newAgentsToday, $newAgentsThisMonth, $newAgentsTotal));
    }
}
