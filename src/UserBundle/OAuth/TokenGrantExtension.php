<?php


namespace UserBundle\OAuth;

use FOS\OAuthServerBundle\Entity\AccessTokenManager;
use FOS\OAuthServerBundle\Entity\RefreshTokenManager;
use FOS\OAuthServerBundle\Storage\GrantExtensionInterface;
use OAuth2\Model\IOAuth2Client;

/**
 * Class TokenGrantExtension
 * @package UserBundle\OAuth
 */
class TokenGrantExtension implements GrantExtensionInterface
{

    /**
     * @var AccessTokenManager
     */
    private $accessTokenManager;

    /**
     * @var RefreshTokenManager
     */
    private $refreshTokenManager;

    public function __construct(AccessTokenManager $accessTokenManager, RefreshTokenManager $refreshTokenManager)
    {
        $this->accessTokenManager = $accessTokenManager;
        $this->refreshTokenManager = $refreshTokenManager;
    }

    /*
     * {@inheritdoc}
     */
    public function checkGrantExtension(IOAuth2Client $client, array $inputData, array $authHeaders)
    {
        var_dump("USAO");
        exit;

    //        if ($user) {
    //            //if you need to return access token with associated user
    //            return array(
    //                'data' => $user
    //            );
    //
    //            //if you need an anonymous user token
    //            return true;
    //        }

        return true;
    }
}