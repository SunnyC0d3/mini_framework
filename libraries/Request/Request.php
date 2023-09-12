<?php

namespace Demo\Request;

class Request 
{
    public function __construct(){}

    public function input( $name )
    {
        return $this->requestFromGETMethod( $name ) ?? $this->requestFromPOSTMethod( $name );
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