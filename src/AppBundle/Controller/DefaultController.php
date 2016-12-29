<?php

namespace AppBundle\Controller;

use CoreBundle\Model\XmppPrebind;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Repository\RepositoryFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/xmpp/test", name="xmpp_test", options={"expose" = true}, defaults={"id": "all"}),
     * @return Response
     */
    public function agentAPIAction()
    {

        $params = [
            "user" => "tijana",
            "password" => "sifra",
            "tld" => "192.168.11.3",
            "boshUrl" => "http://192.168.11.3:7070/http-bind/"
            //For openfire it's something like http://<your-xmpp-fqdn>:7070/http-bind/
        ];
        $xmpp = new XmppPrebind($params);
        echo json_encode($xmpp->connect()); //will return JID, SID, RID as JSON
        exit;
        return new JsonResponse(($data = $agentAPI->toArray()), array_key_exists('errors', $data)? 422:200);
    }

}
