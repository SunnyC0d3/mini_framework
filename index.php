<?php

require 'bootstrap.php';

use Demo\Models\User;

$user = new User();

var_dump( $user->find( 3 ) );
