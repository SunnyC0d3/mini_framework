<?php

use Dotenv\Dotenv;
use Demo\ServiceProvider\AppServiceProvider as App;

require 'functions.php';

$dotenv = Dotenv::createImmutable( dir_path() );
$dotenv->load();

debugging();

App::resolveBinding( 'user' )->where( 'id', '=', 1 )->where( 'id', '=', 1 )->update( [ 'id' => 'testing', 'name' => 'testing' ] );

// $router = App::resolveBinding( 'router' );
// $routes = require base_path( 'routes.php' );
// $router->route();
