<?php

namespace Demo\Rules;

use Demo\Request\Request;

class ValidateRulesBasedOnRequest extends Rules
{
    protected Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    protected function required( $name )
    {
        array_push( $this->validatedRules[ $name ], empty( $this->request->input( $name ) ) ? [ false, 'The ' . $name . ' is required.' ] : [ true, $this->request->input( $name ) ] );
    }

    protected function string( $name )
    {
        array_push( $this->validatedRules[ $name ], ! is_string( $this->request->input( $name ) ) ? [ false, $name . ' is not of type string.' ] : [ true, htmlspecialchars( $this->request->input( $name ), ENT_QUOTES, 'UTF-8' ) ] );
    }

    protected function email( $name )
    {
        array_push( $this->validatedRules[ $name ], ! filter_var( $this->request->input( $name ), FILTER_VALIDATE_EMAIL ) ? [ false, $name . ' is not a valid email address.' ] : [ true, filter_var( $this->request->input( $name ), FILTER_VALIDATE_EMAIL ) ] );
    }

    protected function number( $name )
    {        
        array_push( $this->validatedRules[ $name ], ! is_numeric( $this->request->input( $name ) ) ? [ false, $name . ' is not a valid number.' ] : [ true, $this->request->input( $name ) ] );
    }

    protected function max( $name, $value )
    {
        array_push( $this->validatedRules[ $name ], strlen( $this->request->input( $name ) ) > $value ? [ false, $name . ' count is greater than ' . $value . '.' ] : [ true, $this->request->input( $name ) ] );
    }

    protected function min( $name, $value )
    {
        array_push( $this->validatedRules[ $name ], strlen( $this->request->input( $name ) ) < $value ? [ false, $name . ' count is less than ' . $value . '.' ] : [ true, $this->request->input( $name ) ] );
    }
}