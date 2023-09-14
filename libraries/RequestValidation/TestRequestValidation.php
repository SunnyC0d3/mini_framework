<?php

namespace Demo\RequestValidation;

use Demo\RequestValidation\FormValidation;
use Demo\Rules\Rules;

class TestRequestValidation extends FormValidation
{   
    public function __construct( Rules $rules )
    {
        parent::__construct( $rules );

        $this->rules( [
            'make' => 'required|string'
        ] );
    }   
}