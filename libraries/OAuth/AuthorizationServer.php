<?php

namespace Demo\OAuth;

use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\GrantTypeInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use League\OAuth2\Server\ResponseTypes\AbstractResponseType;
use League\OAuth2\Server\ResponseTypes\BearerTokenResponse;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;

class AuthorizationServer
{
    private $server;
    private $privateKey;
    private $encryptionKey;

    public function __construct(ClientRepositoryInterface $clientRepository, AccessTokenRepositoryInterface $accessTokenRepository, ScopeRepositoryInterface $scopeRepository, ResponseTypeInterface $responseType = null) {
        $this->privateKey = key_path( 'private.key' );
        $this->encryptionKey = $_ENV['ENCRYPTION_KEY'];

        $this->server = new \League\OAuth2\Server\AuthorizationServer($clientRepository, $accessTokenRepository, $scopeRepository, $this->privateKey, $this->encryptionKey);

        $this->server->enableGrantType(
            new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
            new \DateInterval('PT1H') // access tokens will expire after 1 hour
        );
    }
}