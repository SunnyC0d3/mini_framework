<?php

namespace Demo\Models;

class User extends Model
{
    protected string $table = 'users';
    protected array $fillable = [ 'name' ];
    public function __construct()
    {
        parent::__construct();
    }

    public function find() : string
    {
        return parent::where( 'name', '=', 'Sunny Singh' )->where( 'name', '=', 'John' )->execute();
    }
}