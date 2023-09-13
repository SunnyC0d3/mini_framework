<?php

use Demo\App;
use Demo\Container;

use Demo\Router;
use Demo\Request\Request;

$container = new Container();

$container->bind( 'router', function () 
{
    return new Router();
});

$container->bind( 'request', function () 
{
    return new Request();
});

$app = new App( $container );