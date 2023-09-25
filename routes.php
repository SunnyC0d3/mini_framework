<?php

use Demo\Controllers\TestController;

$router->get('/', [new TestController(), 'index'])->middleware(['guest']);