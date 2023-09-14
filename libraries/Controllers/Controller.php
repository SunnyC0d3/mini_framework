<?php

namespace Demo\Controllers;

use Demo\Request\Request;
use Demo\Models\Model;
use Demo\Database;

class Controller 
{
    protected Model $model;
    protected Request $request;

    public function __construct( $model = new Model( new Database() ), Request $request = new Request() )
    {
        $this->model = $model;
        $this->request = $request;
    }
}
