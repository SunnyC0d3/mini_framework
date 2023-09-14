<?php

use Demo\App;
use Demo\Container;

use Demo\Database;
use Demo\Router;
use Demo\Request\Request;
use Demo\Models\User;
use Demo\Rules\ValidateRulesBasedOnRequest;
use Demo\RequestValidation\TestRequestValidation;

$container = new Container();

$container->bind( 'router', function () 
{
    return new Router( new Request() );
});

$container->bind( 'request', function () 
{
    return new Request();
});

$container->bind( 'database', function () 
{
    return new Database();
});

$container->bind( 'user', function() 
{
    return new User( new Database() );
});

$container->bind( 'request_validation', function() 
{
    return new TestRequestValidation( new ValidateRulesBasedOnRequest( new Request() ) );
});

$app = new App( $container );

$request = $app->resolve( 'request' );
$router = $app->resolve( 'router' );
$database = $app->resolve( 'database' );
$user = $app->resolve( 'user' );
$requestValidation = $app->resolve( 'request_validation' );