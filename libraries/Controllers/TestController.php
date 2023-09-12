<?php

namespace Demo\Controllers;

use Demo\RequestValidation\TestRequestValidation;
use Demo\Request\Request;

class TestController 
{
    public function index()
    {
        $request = new Request();
        var_dump( $request->params() );
    }
}