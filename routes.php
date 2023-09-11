<?php

use Demo\Controllers\TestController;

$router->get( '/', [ new TestController(), 'index' ] );
$router->delete( '/', [ new TestController(), 'delete' ] );
$router->patch( '/', [ new TestController(), 'patch' ] );
$router->put( '/', [ new TestController(), 'put' ] );
