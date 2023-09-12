<?php

namespace Demo\RequestValidation;

use Demo\Rules\Rules;
use Demo\Rules\ValidateRulesBasedOnRequest;

class FormRequestValidation
{
    private $validated = false;

    private $validatedObject = [];
    private Rules $rules;

    public function __construct( Rules $rules = null )
    {
        if( $rules === null )
        {
            $this->rules = new ValidateRulesBasedOnRequest();
        }
        else
        {
            $this->rules = $rules;
        }
    }

    public function rules( $rules )
    {
        $this->rules->rules( $rules );
    }
    public function validate()
    {
        $this->validatedObject = $this->rules->getValidatedRules();
        
        $this->validated = true;

        foreach( $this->validatedObject as $name => $records )
        {
            foreach( $records as $record )
            {
                if( $record[ 0 ] === false )
                {
                    $this->validated = false;
                }
            }
        }

        return $this->validatedObject;
    }

    public function validated()
    {
        return $this->validated;
    }
}