<?php

namespace Demo\Middleware;

class MiddlewareLoader extends Middleware
{
    protected $MAP =
        [
            'guest' => GuestMiddleware::class
        ];
}