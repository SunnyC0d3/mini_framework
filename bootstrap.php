<?php

use Dotenv\Dotenv;

require 'functions.php';

$dotenv = Dotenv::createImmutable( dir_path() );
$dotenv->load();

debugging();

require 'serviceProvider.php';

$routes = require base_path( 'routes.php' );
$router->route();
