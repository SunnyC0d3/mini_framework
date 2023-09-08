<?php

require 'bootstrap.php';

use Demo\Models\User;

$user = new User();

$user->find();
