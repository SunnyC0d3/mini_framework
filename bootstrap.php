<?php

use Dotenv\Dotenv;
use Demo\ServiceProvider\AppServiceProvider as App;

require 'functions.php';

$dotenv = Dotenv::createImmutable( dir_path() );
$dotenv->load();

debugging();

/**
 * Create CRUD operations, Create Relationships for Model
 * Create Session Class
 * Create OAuth
 * Add types, descriptions to everything I have done
 */

$user = App::resolveBinding( 'user' );
$user->insert( [ 'name' => 'key', 'id' => 'name' ] );

//$user->where( 'id', '=', '1' )->delete();

// $router = App::resolveBinding( 'router' );
// $routes = require base_path( 'routes.php' );
// $router->route();
