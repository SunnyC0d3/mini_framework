<?php

namespace Demo\RequestValidation;

use Demo\RequestValidation\FormRequestValidation;

class TestRequestValidation extends FormRequestValidation
{   
    public function __construct()
    {
        parent::__construct();

        $this->rules( [
            'make' => 'required|string'
        ] );
    }   
}