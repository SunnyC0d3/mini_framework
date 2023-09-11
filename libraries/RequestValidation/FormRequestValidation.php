<?php

namespace Demo\RequestValidation;

use Exception;

class FormRequestValidation
{
    private $rules = [
        'required',
        'min',
        'max',
        'string',
        'number',
        'email'
    ];

    public function __construct(){}

    public function rules( $request )
    {

    }
    public function validate( $request )
    {
        $this->validateIncomingRequest( $request );
        $this->serialiseRules( $request );
    }

    private function validateIncomingRequest( $request )
    {
        if( empty( $request ) )
        {
            throw new Exception( 'The request is empty.' );
        }

        if( ! is_array( $request ) )
        {
            throw new Exception( 'The request is not of type array.' );
        } 
    }
    
    private function serialiseRules( $request )
    {
        $temp_rules = [];

        foreach( $request as $name => $unserialised_rules )
        {
            $this->validateRules( $unserialised_rules );

            $rules = explode( '|', $unserialised_rules );

            $temp_rules[ $name ] = [];

            foreach( $rules as $rule )
            {
                $this->validateInputsAgainstRules( $rule );
                array_push( $temp_rules[ $name ], $this->callMethodRelatedToRule( $rule, $name ) );
            }
        }

        var_dump( $temp_rules );
    }

    private function validateRules( $rules )
    {
        if( empty( $rules ) )
        {
            throw new Exception( 'No rules specified.' );
        }
    }

    private function validateInputsAgainstRules( $rule )
    {
        if( ! in_array( $rule, $this->rules ) )
        {
            throw new Exception( $rule . ' key specified is not covered in the rules.' );
        }
    }

    private function callMethodRelatedToRule( $rule, $name )
    {
        return call_user_func_array( [ $this, $rule ], [ $name ] );
    }

    private function checkRequest( $name )
    {
        return isset( $_GET[ $name ] ) ?? isset( $_POST[ $name ] );
    }

    private function required( $name )
    {
        $request = $this->checkRequest( $name );

        return empty( $request ) ? 'The ' . $name . ' is required.' : '';
    }

    private function string( $name )
    {
        $request = $this->checkRequest( $name );
        
        return ! is_string( $request ) ? $name . ' is not of type string.' : '';
    }
}