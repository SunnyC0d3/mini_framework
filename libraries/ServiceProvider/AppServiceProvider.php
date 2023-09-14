<?php

namespace Demo\ServiceProvider;

use Demo\Database;
use Demo\Router;
use Demo\Request\Request;
use Demo\Models\User;
use Demo\Rules\ValidateRulesBasedOnRequest;
use Demo\RequestValidation\FormValidation;

class AppServiceProvider extends Container
{
    protected function register()
    {
        $this->bind( 'router', function () 
        {
            return new Router( new Request() );
        });

        $this->bind( 'request', function () 
        {
            return new Request();
        });

        $this->bind( 'user', function() 
        {
            return new User( new Database() );
        });

        $this->bind( 'request_validation', function() 
        {
            return new FormValidation( new ValidateRulesBasedOnRequest( new Request() ) );
        });
    }

    public static function resolveBinding( $key )
    {
        $instance = new self();
        $instance->register();
        
        return $instance->resolve( $key );
    }
}