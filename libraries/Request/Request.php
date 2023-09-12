<?php

namespace Demo\Request;

class Request 
{
    public function __construct(){}

    public function input( $name )
    {
        return $this->requestFromGETMethod( $name ) ?? $this->requestFromPOSTMethod( $name );
    }

    public function https()
    {
        return isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' ? 'https://' : 'http://';
    }

    public function host()
    {
        return parse_url( $this->https() . $_SERVER[ 'HTTP_HOST' ], PHP_URL_HOST );
    }

    public function path()
    {
        return parse_url( $_SERVER[ 'REQUEST_URI' ], PHP_URL_PATH );
    }

    public function port()
    {
        return parse_url( $this->url(), PHP_URL_PORT );
    }

    public function url()
    {
        return $this->https() . $this->host() . $this->path();
    }

    public function params()
    {
        return parse_url( $this->url(), PHP_URL_QUERY );
    }

    public function serverMethod( $method = '_method' )
    {
        return $_POST[ $method ] ?? $_SERVER[ 'REQUEST_METHOD' ];
    }

    private function requestFromGETMethod( $name )
    {
        return isset( $_GET[ $name ] );
    }

    private function requestFromPOSTMethod( $name )
    {
        return isset( $_POST[ $name ] );
    }
}