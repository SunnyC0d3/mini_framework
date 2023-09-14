<?php

use Dotenv\Dotenv;
use Demo\ServiceProvider\AppServiceProvider as App;

require 'functions.php';

$dotenv = Dotenv::createImmutable( dir_path() );
$dotenv->load();

debugging();

$router = App::resolveBinding( 'router' );
$routes = require base_path( 'routes.php' );
$router->route();
