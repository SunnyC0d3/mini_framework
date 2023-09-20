<?php

use Dotenv\Dotenv;
use Demo\ServiceProvider\AppServiceProvider as App;

require 'functions.php';

$dotenv = Dotenv::createImmutable( dir_path() );
$dotenv->load();

debugging();

/**
 * Create Relationships for Model
 * Create Session Class
 * Create OAuth
 * Add types, descriptions to everything I have done
 */

// $router = App::resolveBinding( 'router' );
// $routes = require base_path( 'routes.php' );
// $router->route();
