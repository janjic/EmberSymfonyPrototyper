<?php

namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\OAuthServerBundle\Controller\TokenController as BaseController;
use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TokenController
 * @package UserBundle\Controller
 */
class TokenController extends BaseController {

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * TokenController constructor.
     * @param OAuth2 $server
     * @param EntityManager $entityManager
     */
    public function __construct(OAuth2 $server, EntityManager $entityManager)
    {
        parent::__construct($server);
        $this->em           = $entityManager;
    }

    public function tokenAction(Request $request)
    {
        $regex = '#^(authorization_code|token|password|client_credentials|refresh_token|https?://.+|urn:.+)$#';
        $filters = array(
            "grant_type" => array(
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => array("regexp" => $regex),
                "flags" => FILTER_REQUIRE_SCALAR
            ),
            "scope" => array("flags" => FILTER_REQUIRE_SCALAR),
            "code" => array("flags" => FILTER_REQUIRE_SCALAR),
            "redirect_uri" => array("filter" => FILTER_SANITIZE_URL),
            "username" => array("flags" => FILTER_REQUIRE_SCALAR),
            "password" => array("flags" => FILTER_REQUIRE_SCALAR),
            "refresh_token" => array("flags" => FILTER_REQUIRE_SCALAR),
        );

        if ($request === null) {
            $request = Request::createFromGlobals();
        }

        // Input data by default can be either POST or GET
        if ($request->getMethod() === 'POST') {
            $inputData = $request->request->all();
        } else {
            $inputData = $request->query->all();
        }

        $input = filter_var_array($inputData, $filters);
        /** @var Response $response */
        $response = parent::tokenAction($request);
        $token = json_decode($response->getContent());

        if (!property_exists($token, 'error')&& ($username = $input['username'])) {
             $token->account_id = $this->em->getRepository('UserBundle:User')->findOneBy(array('username' =>$username))->getId();
        }

        $response->setContent(json_encode($token));

        return $response;
    }
}
