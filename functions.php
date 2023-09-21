<?php

function debugging()
{
    if( $_ENV[ 'DEBUG' ] !== 'false' && $_ENV[ 'DEBUG' ] === 'true' )
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

function view_path( $path = '', $attributes = [] )
{
    extract( $attributes );

    return base_path( 'views/' . $path );
}

function resource_path( $path = '' )
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

function removePlurals( $input )
{
    foreach ( [ 's', 'es', 'ies' ] as $suffix ) 
    {
        if ( substr( $input, -strlen( $suffix ) ) === $suffix ) 
        {
            return substr( $input, 0, -strlen( $suffix ) );
        }
    }
    return $input;
}