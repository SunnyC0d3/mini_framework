<?php

namespace Demo\RequestValidation;

use Exception;

//Validation Rules for Requests, need to create a class for each type of request I am handling e.g. Test
//TestRequest
    //Just have some specified fields that needs to be checked and params that need to be checked against
//Now when a controller is activated via route,
    //Controller will automatically pick up the TestRequest and run that first before continuing

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

    
    public function serialiseRules( $request )
    {
        foreach( $request as $name => $unserialised_rules )
        {
            $rules = explode( '|', $unserialised_rules );
            foreach( $rules as $rule )
            {
                $this->validateInputsAgainstRules( $rule );
            }
        }
    }

    private function validateInputsAgainstRules( $rule )
    {
        if( ! in_array( $rule, $this->rules ) )
        {
            throw new Exception( $rule . ' key specified is not covered in the rules.' );
        }
    }

    // private function checkIfRuleHasColon( $rule )
    // {
    //     if ( strpos( $rule, ':' ) !== false ) 
    //     {
    //         $values = explode( ':', $rule );
    //     }
    // }
}

/**
 * $validator = new FormRequestValidation();
 * 
 * $validated = $validator->validate([
 *  'make' => 'required|string|min:1|max:255'
 * ]);
 * 
 * if( $validated )
 * 
 */