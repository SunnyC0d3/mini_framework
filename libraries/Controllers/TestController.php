<?php

namespace Demo\Controllers;

use Demo\ServiceProvider\AppServiceProvider as App;

class TestController extends Controller
{
    private $validator;

    public function __construct()
    {
        parent::__construct();

        $this->validator = App::resolveBinding('request_validation');
    }

    public function index()
    {
        echo 'testing';
    }
}
