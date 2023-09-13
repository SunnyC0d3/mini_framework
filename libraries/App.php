<?php

namespace Demo;

class App
{
    protected $container;

    public function __construct( $container )
    {
        $this->container = $container;
    }

    public function bind( $key, $resolver )
    {
        $this->container->bind( $key, $resolver );
    }

    public function resolve( $key )
    {
        return $this->container->resolve( $key );
    }
}