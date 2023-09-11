<?php

use Demo\Controllers\TestController;
use Demo\RequestValidation\FormRequestValidation;

$router->get( '/', [ new TestController(), 'index' ] );
$router->delete( '/', [ new TestController(), 'delete' ] );
$router->patch( '/', [ new TestController(), 'patch' ] );
$router->put( '/', [ new TestController(), 'put' ] );

$validator = new FormRequestValidation();
$validator->validate( [ 
    'make' => 'required|string',
    'model' => 'required|email'
] );
