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
        $invalidation = [];

        foreach( $request as $name => $unserialised_rules )
        {
            $this->validateRules( $unserialised_rules );

            $rules = explode( '|', $unserialised_rules );

            $invalidation[ $name ] = [];

            foreach( $rules as $rule )
            {
                $this->validateInputsAgainstRules( $rule );
                array_push( $invalidation[ $name ], $this->callMethodRelatedToRule( $this->colonKeyCheck( $rule ), $name, $this->colonValueCheck( $rule ) ) );
            }
        }

        dd( $invalidation );
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
        return empty( checkRequest( $name ) ) ? 'The ' . $name . ' is required.' : '';
    }

    private function string( $name )
    {
        return ! is_string( checkRequest( $name ) ) ? $name . ' is not of type string.' : '';
    }

    private function email( $name )
    {
        return ! filter_var( checkRequest( $name ), FILTER_VALIDATE_EMAIL ) ? $name . ' is not a valid email address.' : '';
    }

    private function number( $name )
    {        
        return ! is_numeric( checkRequest( $name ) ) ? $name . ' is not a valid number.' : '';
    }

    private function max( $name, $value )
    {
        return strlen( checkRequest( $name ) ) > $value ? $name . ' count is greater than ' . $value . '.' : '';
    }

    private function min( $name, $value )
    {
        return strlen( checkRequest( $name ) ) < $value ? $name . ' count is less than ' . $value . '.' : '';
    }
}