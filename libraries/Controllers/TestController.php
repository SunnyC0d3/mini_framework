<?php

namespace Demo\Controllers;
use Demo\ServiceProvider\AppServiceProvider as App;

class TestController extends Controller
{
    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = App::resolveBinding( 'request_validation' );
    }

    public function index()
    {
        /**
         * 
         * Create Middleware
         * 
         * Create the rest of the CRUD and relationship methods for Model
         * 
         */

        $this->validator->rules([
            'make' => 'required|string'
        ]);

        dd( $this->validator->validate() );
    }
}
