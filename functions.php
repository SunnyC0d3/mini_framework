<?php

function dir_path( $path = '' )
{
    return __DIR__ . $path;
}

function base_path( $path = '' )
{
    return __DIR__ . '/' . $path;
}

function views_path( $path = '' )
{
    return base_path( 'views/' . $path );
}

function resources_path( $path = '' )
{
    return base_path( 'resources/' . $path );
}
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