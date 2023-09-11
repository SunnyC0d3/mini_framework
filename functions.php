<?php

const DIR = __DIR__;
const BASE_PATH = __DIR__ . '/';

function checkRequest( $name )
{
    return isset( $_GET[ $name ] ) ?? isset( $_POST[ $name ] );
}

function dd( $error )
{
    echo '<pre>';
    print_r( $error );
    echo '</pre>';
    die();
}