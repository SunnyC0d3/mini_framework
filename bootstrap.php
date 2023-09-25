<?php

use Dotenv\Dotenv;
use Demo\ServiceProvider\AppServiceProvider as App;

require 'functions.php';

$dotenv = Dotenv::createImmutable(dir_path());
$dotenv->load();

debugging();

/**
 * Create Session Class
 * Create OAuth
 * Add types/strict, descriptions to everything I have done
 * Testing
 */

$user = App::resolveBinding('user');
dd($user->with('notes')->with('customers')->get());

// $router = App::resolveBinding( 'router' );
// $routes = require base_path( 'routes.php' );
// $router->route();
