<?php

namespace Demo\Middleware;

use Demo\Middleware\IMiddleware;

class GuestMiddleware implements IMiddleware
{
    public function handle()
    {
        echo 'Loaded Middleware';
    }
}
