<?php

namespace App\Framework;

abstract class ServiceProvider
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    // This method is intended for registering services in the container
    public function register()
    {
        //
    }

    // This method is intended to run code once everything is ready
    public function boot()
    {
        //
    }
}
