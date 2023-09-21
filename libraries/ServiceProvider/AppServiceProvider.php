<?php

namespace Demo\ServiceProvider;

use Demo\Database;
use Demo\Router;
use Demo\Request\Request;
use Demo\Models\User;
use Demo\Models\Relationship;
use Demo\Rules\ValidateRulesBasedOnRequest;
use Demo\RequestValidation\FormValidation;
use Demo\Middleware\MiddlewareLoader;

class AppServiceProvider extends Container
{
    protected function register()
    {
        $services = [
            'router' => new Router( new Request(), new MiddlewareLoader() ),
            'request' => new Request(),
            'user' => new User( new Database() ),
            'request_validation' => new FormValidation( new ValidateRulesBasedOnRequest( new Request() ) ),
            'relationship' => new Relationship( new Database() )
        ];

        foreach( $services as $service => $dependencies )
        {
            $this->bind( $service, function() use ( $dependencies )
            {
                return $dependencies;
            });
        }
    }

    public static function resolveBinding( $key )
    {
        $instance = new self();
        $instance->register();
        
        return $instance->resolve( $key );
    }
}