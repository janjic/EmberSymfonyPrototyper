<?php

namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\OAuthServerBundle\Controller\TokenController as BaseController;
use FOS\OAuthServerBundle\Storage\OAuthStorage;
use FOS\UserBundle\Model\UserManagerInterface;
use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends BaseController {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var OAuthStorage
     */
    private $authStorage;


    /**
     * TokenController constructor.
     * @param OAuth2 $server
     * @param EntityManager $entityManager
     * @param UserManagerInterface $userManager
     * @param OAuthStorage $authStorage
     */
    public function __construct(OAuth2 $server, EntityManager $entityManager, UserManagerInterface $userManager, OAuthStorage $authStorage)
    {
        parent::__construct($server);
        $this->em           = $entityManager;
        $this->userManager  = $userManager;
        $this->authStorage = $authStorage;

    }

    public function tokenAction(Request $request)
    {
        /** @var Response $response */
        $response = parent::tokenAction($request);
        $token = json_decode($response->getContent());

        if (property_exists($token, 'refresh_token')) {
            $refreshToken =  $this->authStorage->getRefreshToken($token->refresh_token);
            if ($refreshToken && ($user = $refreshToken->getUser())) {
                $token->account_id = $user->getId();
            }
        }

        $response->setContent(json_encode($token));

        return $response;
    }
}
