<?php

namespace Demo\Middleware;

class Middleware
{
    protected $MAP = [];

    public function resolve($key)
    {
        if (!$key) {
            return;
        }

        $middleware = $this->MAP[$key] ?? false;

        if (!$middleware) {
            throw new \Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}
