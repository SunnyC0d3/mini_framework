<?php

namespace Demo\Rules;

use Demo\Rules\IRules;
use Exception;

class Rules implements IRules
{
    protected $rules = [
        'required',
        'min',
        'max',
        'string',
        'number',
        'email'
    ];

    protected $validatedRules = [];

    protected $customRules = [];

    public function rules( $rules )
    {
        $this->customRules = $rules;
    }

    public function getValidatedRules()
    {
        $this->serialiseRules( $this->customRules );

        return $this->validatedRules;
    }

    protected function serialiseRules( $rules )
    {
        $this->validateRulesObject( $rules );

        foreach( $rules as $name => $unserialised_rules )
        {
            $this->validateRules( $unserialised_rules );

            $this->validatedRules[ $name ] = [];

            $rules = explode( '|', $unserialised_rules );

            foreach( $rules as $rule )
            {
                $this->validateInputsAgainstRules( $rule );
                $this->callMethodRelatedToRule( $this->colonKeyCheck( $rule ), $name, $this->colonValueCheck( $rule ) );
            }
        }
    }

    protected function validateRulesObject( $rules )
    {
        if( ! is_array( $rules ) )
        {
            throw new Exception( 'The rules specified are not of type array.' );
        }

        $this->validateRules( $rules );
    }

    protected function validateRules( $rules )
    {
        if( empty( $rules ) )
        {
            throw new Exception( 'The rules are empty.' );
        }
    }

    protected function validateInputsAgainstRules( $rule )
    {
        $rule = $this->colonKeyCheck( $rule );

        if( ! in_array( $rule, $this->rules ) )
        {
            throw new Exception( $rule . ' key specified is not covered in the rules.' );
        }
    }

    protected function colonKeyCheck( $rule )
    {
        if( strpos( $rule, ':' ) === false )
        {
            return $rule;
        }

        return explode( ':', $rule )[ 0 ];
    }

    protected function colonValueCheck( $rule )
    {
        if( strpos( $rule, ':' ) === false )
        {
            return;
        }

        return explode( ':', $rule )[ 1 ];
    }

    protected function callMethodRelatedToRule( $rule, $name, $optionalValue = '' )
    {
        if( $optionalValue !== '' )
            return call_user_func_array( [ $this, $rule ], [ $name, $optionalValue ] );

        return call_user_func_array( [ $this, $rule ], [ $name ] );
    }
}