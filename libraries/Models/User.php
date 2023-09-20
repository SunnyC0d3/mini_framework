<?php

namespace Demo\Models;

class User extends Model
{
    protected string $table = 'users';
    protected array $fillable = [ 
        'id',
        'name',
        'email'
    ];
}