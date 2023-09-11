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

    private $invalidation = [
        
    ];

    private $validated = false;

    private $customRules = [];

    public function __construct(){}

    public function rules( $request )
    {
        $this->customRules = $request;
    }
    public function validate()
    {
        $this->validateIncomingRequest( $this->customRules );
        $this->serialiseRules( $this->customRules );

        foreach( $this->invalidation as $name => $records )
        {
            foreach( $records as $record )
            {
                $this->validated = true;

                if( $record[ 0 ] === false )
                {
                    $this->validated = false;
                }
            }
        }
    }

    public function validated()
    {
        return $this->validated;
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
        foreach( $request as $name => $unserialised_rules )
        {
            $this->validateRules( $unserialised_rules );

            $this->invalidation[ $name ] = [];

            $rules = explode( '|', $unserialised_rules );

            foreach( $rules as $rule )
            {
                $this->validateInputsAgainstRules( $rule );
                $this->callMethodRelatedToRule( $this->colonKeyCheck( $rule ), $name, $this->colonValueCheck( $rule ) );
            }
        }
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
        $rule = $this->colonKeyCheck( $rule );

        if( ! in_array( $rule, $this->rules ) )
        {
            throw new Exception( $rule . ' key specified is not covered in the rules.' );
        }
    }

    private function colonKeyCheck( $rule )
    {
        if( strpos( $rule, ':' ) === false )
        {
            return $rule;
        }

        return explode( ':', $rule )[ 0 ];
    }

    private function colonValueCheck( $rule )
    {
        if( strpos( $rule, ':' ) === false )
        {
            return;
        }

        return explode( ':', $rule )[ 1 ];
    }

    private function callMethodRelatedToRule( $rule, $name, $optionalValue = '' )
    {
        if( $optionalValue !== '' )
            return call_user_func_array( [ $this, $rule ], [ $name, $optionalValue ] );

        return call_user_func_array( [ $this, $rule ], [ $name ] );
    }

    private function required( $name )
    {
        array_push( $this->invalidation[ $name ], empty( checkRequest( $name ) ) ? [ false, 'The ' . $name . ' is required.' ] : [ true, checkRequest( $name ) ] );
    }

    private function string( $name )
    {
        array_push( $this->invalidation[ $name ], ! is_string( checkRequest( $name ) ) ? [ false, $name . ' is not of type string.' ] : [ true, htmlspecialchars( checkRequest( $name ), ENT_QUOTES, 'UTF-8' ) ] );
    }

    private function email( $name )
    {
        array_push( $this->invalidation[ $name ], ! filter_var( checkRequest( $name ), FILTER_VALIDATE_EMAIL ) ? [ false, $name . ' is not a valid email address.' ] : [ true, filter_var( checkRequest( $name ), FILTER_VALIDATE_EMAIL ) ] );
    }

    private function number( $name )
    {        
        array_push( $this->invalidation[ $name ], ! is_numeric( checkRequest( $name ) ) ? [ false, $name . ' is not a valid number.' ] : [ true, checkRequest( $name ) ] );
    }

    private function max( $name, $value )
    {
        array_push( $this->invalidation[ $name ], strlen( checkRequest( $name ) ) > $value ? [ false, $name . ' count is greater than ' . $value . '.' ] : [ true, checkRequest( $name ) ] );
    }

    private function min( $name, $value )
    {
        array_push( $this->invalidation[ $name ], strlen( checkRequest( $name ) ) < $value ? [ false, $name . ' count is less than ' . $value . '.' ] : [ true, checkRequest( $name ) ] );
    }
}