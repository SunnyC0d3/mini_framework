<?php

use Demo\Controllers\TestController;

$router->get( '/testing', [ new TestController(), 'index' ] )->middleware( [ 'guest' ] );
// $router->delete( '/', [ new TestController(), 'delete' ] );
// $router->patch( '/', [ new TestController(), 'patch' ] );
// $router->put( '/', [ new TestController(), 'put' ] );
