<?php

namespace Demo\Controllers;

use Demo\RequestValidation\FormRequestValidation;

class TestController 
{
    public function index()
    {
        $validator = new FormRequestValidation();
        $validator->rules( [
            'make' => 'required|string'
        ] );
        $validator->validate();

        var_dump( $validator->validated() );
    }
}