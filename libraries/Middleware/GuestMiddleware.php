<?php

namespace Demo\Middleware;

class GuestMiddleware
{
    public function handle()
    {
        echo 'Loaded Middleware';
    }
}
