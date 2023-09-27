<?php

use Dotenv\Dotenv;
use Demo\ServiceProvider\AppServiceProvider as App;
use Demo\OAuth\AuthorizationServer;
use Demo\OAuth\ClientRepository;
use Demo\OAuth\AccessTokenRepository;
use Demo\OAuth\ScopeRepository;

require 'functions.php';

$dotenv = Dotenv::createImmutable(dir_path());
$dotenv->load();

debugging();

/**
 * Setup SSL thats working
 * Create OAuth
 * Add types/strict, descriptions to everything I have done
 * Testing
 */

 // Init our repositories
$clientRepository = new ClientRepository(); // instance of ClientRepositoryInterface
$scopeRepository = new ScopeRepository(); // instance of ScopeRepositoryInterface
$accessTokenRepository = new AccessTokenRepository(); // instance of AccessTokenRepositoryInterface


// Setup the authorization server
$server = new AuthorizationServer(
    $clientRepository,
    $accessTokenRepository,
    $scopeRepository
);

return $server;

// $router = App::resolveBinding( 'router' );
// $routes = require base_path( 'routes.php' );
// $router->route();

// curl -X "POST" "https://demo.co.uk/" \
// 	-H "Content-Type: application/x-www-form-urlencoded" \
// 	-H "Accept: 1.0" \
// 	--data-urlencode "grant_type=client_credentials" \
// 	--data-urlencode "client_id=myawesomeapp" \
// 	--data-urlencode "client_secret=abc123" \
// 	--data-urlencode "scope=basic email"