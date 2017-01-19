<?php

namespace UserBundle\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TestController
 * @package UserBundle\Controller
 */
class TestController extends Controller
{
    /**
     * @Route("/test", name="test", defaults={"user_param": "all"}),
     * @return JsonResponse
     */
    public function testAction()
    {
        $customers = [];
        $customers["id"] = 108;
        $customers["month_1"]= "0";
        $customers["month_2"]= "0";
        $customers["month_3"]= "0";
        $customers["month_4"]= "0";
        $customers["month_5"]= "0";
        $customers["month_6"]= "0";
        $customers["month_7"]= "1";
        $customers["month_8"]= "1";
        $customers["month_9"]= "1";
        $customers["month_10"]= "1";
        $customers["month_11"]= "1";
        $customers["month_12"]= "1";

        $order = [];

        $client        = new Client();
        $server        = 'https://192.168.11.3';
        $client_id     = '1_lxfu6l5i1tco04cok4ck0o0ocgoc04wwksssgco48sg4w8cog';
        $client_secret = '4q062irkhq0w4ocggcggsw4csswgswcwswowckokk8ssoskko4';

        $url = sprintf('%s/oauth/v2/token?grant_type=client_credentials&client_id=%s&client_secret=%s', $server, $client_id, $client_secret);

        try {
            $promise = $client->requestAsync("GET", $url, ['verify' => false]);

            $answer = null;
            $promise->then(
                function (ResponseInterface $res) use (&$answer, $client, $server, $order, $customers) {
                    $answer = $res->getBody()->getContents();

                    $accessToken = json_decode($answer)->access_token;

                    $url = sprintf('%s/app_dev.php/api/payment/process_payment', $server);

                    $headers = [
                        'Content-Type' => "application/json",
                        'Authorization' => 'Bearer ' . $accessToken
                    ];

                    $data = [
                        'agentId'            => 112,
                        'orderId'            => 2,
                        'customerId'         => 2,
                        'sumPackages'        => 100,
                        'sumConnect'         => 100,
                        'sumOneTimeSetupFee' => 100,
                        'sumStreams'         => 100,
                        'currency'           => 'EUR',
                        'customersInAYear'   => $customers
                    ];


                    $request = new Request('POST', $url, $headers, json_encode($data));

                    $response = $client->send($request, ['verify' => false]);
                    $answer = json_decode($response->getBody()->getContents());

                },
                function (RequestException $e) use (&$answer) {
                    $answer = $e->getMessage();
                }
            );
            $promise->wait();

            var_dump($answer);die();

        } catch (\Exception $e) {
            var_dump($e->getMessage());die();
        }


        /**return JSON Response */
        return new JsonResponse($userJqgrid->toArray());
    }
}