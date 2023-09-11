<?php

require 'bootstrap.php';

use Demo\Models\User;

$user = new User();

var_dump( $user->where( 'name', '=', 'Sunny Singh' )->orWhere( 'name', '=', 'John' )->get() );
