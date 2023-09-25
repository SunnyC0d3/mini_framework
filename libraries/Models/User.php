<?php

namespace Demo\Models;

use Demo\Database;

class User extends Model
{
    protected string $table = 'users';
    protected array $fillable = [
        'id',
        'name',
        'email'
    ];

    public function __construct(Database $db)
    {
        parent::__construct($db);

        $this->relationship->belongsTo = [
            'notes'
        ];
    }
}