<?php

use Demo\Controllers\TestController;

$router->get('/testing', [new TestController(), 'index'])->middleware(['guest']);