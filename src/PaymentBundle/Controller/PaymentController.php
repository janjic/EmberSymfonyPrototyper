<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
            (int) $request->request->get('orderId')
        );

        return new JSONResponse($payments);
    }

    /**
     * @Route("/api/payment/process_payment", name="process_payment", options={"expose" = true})
     * @param Request $request
     * @return JsonResponse
     */
    public function processPaymentAction(Request $request)
    {
        $data = json_decode($request->getContent());

        $payments = $this->get('agent_system.payment_info.manager')->calculateCommissions(
            (int) $data->agentId,
            (float) $data->sumPackages,
            (float) $data->sumConnect,
            (float) $data->sumOneTimeSetupFee,
            (float) $data->sumStreams,
            (int) $data->customerId,
            (int) $data->orderId
        );

        if ($payments) {
            return new JSONResponse(['code' => 200]);
        } else {
            return new JSONResponse(['code' => 500]);
        }
    }

}
