<?php

namespace Demo\Models;

class User extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->fillable = [
            'name'
        ];
    }

    public function find()
    {
        parent::where( 'name', '=', 'test' )->find();
    }
}