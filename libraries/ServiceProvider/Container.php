<?php

namespace Demo\ServiceProvider;

use Exception;

abstract class Container
{
    protected $bindings = [];

    protected abstract function register();

    public abstract static function resolveBinding( $key );

    protected function bind( $key, $resolver )
    {
        $this->bindings[ $key ] = $resolver;
    }

    protected function resolve( $key )
    {                
        if ( !array_key_exists( $key, $this->bindings ) ) 
        {
            throw new Exception( "No matching binding found for {$key}" );
        }

        $resolver = $this->bindings[ $key ];

        return call_user_func( $resolver );
    }
}