<?php

require 'vendor/autoload.php';
require 'functions.php';

use Demo\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable( dir_path() );
$dotenv->load();

debugging();

$router = new Router();
$routes = require base_path( 'routes.php' );

$router->route();
