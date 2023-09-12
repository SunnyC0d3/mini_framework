<?php

namespace Demo\Controllers;

use Demo\RequestValidation\TestRequestValidation;

class TestController 
{
    public function index()
    {
        $validator = new TestRequestValidation();

        var_dump( $validator->validate() );
    }
}