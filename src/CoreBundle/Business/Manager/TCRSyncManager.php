<?php

namespace CoreBundle\Business\Manager;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Interface TCRSyncManager
 * @package CoreBundle\Business\Manager
 */
class TCRSyncManager implements BasicEntityManagerInterface
{
    const TCR_SERVER = 'http://tcr-media.fsd.rs:105/';

    public function getContentFromTCR($url)
    {
        $client = new Client();
        $url = self::TCR_SERVER . $url;

        $options = [
            'headers' => [
                'content-type' => "application/json",
                'Accept' => "application/json",
                'Accept-Language' => "sr-RS,sr;q=0.8,en-US;q=0.6,en;q=0.4"
            ]
        ];

        $promise = $client->requestAsync('POST', $url, $options);

        $answer = null;
        $promise->then(
            function (ResponseInterface $res) use (&$answer) {
                $answer = $res->getBody()->getContents();
            },
            function (RequestException $e) use (&$answer) {
                $answer = $e->getMessage();
            }
        );
        $promise->wait();

        return json_decode($answer);
    }

    public function sendDataToTCR($url, $data)
    {
        $client = new Client();
        $url = self::TCR_SERVER . $url;

        $headers = [
            'content-type' => "application/json",
            'Accept' => "application/json",
            'Accept-Language' => "sr-RS,sr;q=0.8,en-US;q=0.6,en;q=0.4"
        ];

        $request = new Request('POST', $url, $headers, $data);
        $response = $client->send($request);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $string
     * @param bool $capitalizeFirstCharacter
     * @return mixed
     */
    function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }

    /**
     * @param $string
     * @return mixed
     */
    function middleDashesToLower($string)
    {
        return str_replace('-', '_', $string);
    }
}