<?php

require 'vendor/autoload.php';
require 'functions.php';

use Dotenv\Dotenv;
use Demo\Router;

$dotenv = Dotenv::createImmutable( DIR );
$dotenv->load();

if( $_ENV[ 'DEBUG' ] !== 'false' )
{
    error_reporting( E_ALL );
    ini_set( 'display_errors', 1 );
}

$router = new Router();
$routes = require BASE_PATH . 'routes.php';

$router->route();
