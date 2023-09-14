<?php

namespace Demo;

use Exception;
use Demo\Request\Request;

class Router
{
    private $routes = [];
    private Request $request;

    public function __construct( Request $request )
    {
        $this->request = $request;
    }

    private function add( $method, $uri, $callable )
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'callable' => $callable
        ];

        return $this;
    }

    public function get( $uri, $callable )
    {
        $this->validateRoute( 'GET', $uri, $callable );

        return $this->add( 'GET', $uri, $callable );
    }

    public function delete( $uri, $callable )
    {
        $this->validateRoute( 'DELETE', $uri, $callable );

        return $this->add( 'DELETE', $uri, $callable );
    }

    public function patch( $uri, $callable )
    {
        $this->validateRoute( 'PATCH', $uri, $callable );

        return $this->add( 'PATCH', $uri, $callable );
    }

    public function put( $uri, $callable )
    {
        $this->validateRoute( 'PUT', $uri, $callable );

        return $this->add( 'PUT', $uri, $callable );
    }

    public function route()
    {
        foreach( $this->routes as $route )
        {
            if( $route[ 'uri' ] === $this->request->path() && $route[ 'method' ] === $this->request->serverMethod() )
            {
                return call_user_func( [ $route[ 'callable' ][ 0 ], $route[ 'callable' ][ 1 ] ] );
            }
        }
    }

    private function validateRoute( $method, $uri, $callable )
    {
        $this->validateMethod( $method );
        $this->validateURI( $uri );
        $this->validateCallable( $callable );
    }

    private function validateMethod( $method )
    {
        if ( empty( $method ) || ! is_string( $method ) ) 
        {
            throw new Exception( 'Type of method is not specified in the Route.' );
        }
    }

    private function validateURI( $uri )
    {
        if ( empty( $uri ) || ! is_string( $uri ) ) 
        {
            throw new Exception( 'Type of URI is not specified in the Route.' );
        }
    }

    private function validateCallable( $callable )
    {
        if( count( $callable ) === 2 && is_array( $callable ) )
        {
            if( ! is_object( $callable[ 0 ] ) )
            {
                throw new Exception( 'The first index should be of type Object in the Route.' );
            }

            if( ! is_string( $callable[ 1 ] ) )
            {
                throw new Exception( 'The second index should be of type String in the Route.' );
            }
        }

        if( count( $callable ) !== 2 || ! is_array( $callable ) )
        {
            throw new Exception( 'The callable should be of type array with a callable function and a method name in the Route.' );
        }
    }
}