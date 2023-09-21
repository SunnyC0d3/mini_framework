<?php

use Dotenv\Dotenv;
use Demo\ServiceProvider\AppServiceProvider as App;

require 'functions.php';

$dotenv = Dotenv::createImmutable(dir_path());
$dotenv->load();

debugging();

/**
 * Create Relationships for Model
 * Fix SQL injections
 * Create Session Class
 * Create OAuth
 * Add types, descriptions to everything I have done
 * Look at plugins to auto format
 * Add strict
 */

$relationship = App::resolveBinding('relationship');

$relationship->hasOne('notes');
dd($relationship->eagerLoad('users', 'notes'));

// $router = App::resolveBinding( 'router' );
// $routes = require base_path( 'routes.php' );
// $router->route();
