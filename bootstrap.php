<?php

require 'vendor/autoload.php';
require 'functions.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable( dir_path() );
$dotenv->load();

debugging();

require 'serviceProvider.php';

$router = $app->resolve( 'router' );
$routes = require base_path( 'routes.php' );

$router->route();

/**
 * 
 * Remove the use of excessibely calling new files of the same class in different parts
 * 
 * e.g. new Request in Router, new Request in ValidateRulesBasedOnRequest, , new Database in Model
 * 
 */