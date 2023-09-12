<?php

require 'vendor/autoload.php';
require 'functions.php';

use Dotenv\Dotenv;
use Demo\Router;

$dotenv = Dotenv::createImmutable( dir_path() );
$dotenv->load();

if( $_ENV[ 'DEBUG' ] !== 'false' )
{
    error_reporting( E_ALL );
    ini_set( 'display_errors', 1 );
}

$router = new Router();
$routes = require base_path( 'routes.php' );

$router->route();
