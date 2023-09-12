<?php

function debugging()
{
    if( $_ENV[ 'DEBUG' ] !== 'false' )
    {
        error_reporting( E_ALL );
        ini_set( 'display_errors', 1 );
    }
}

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

function dd( $error )
{
    echo '<pre>';
    print_r( $error );
    echo '</pre>';
    die();
}