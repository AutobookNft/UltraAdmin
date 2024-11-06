<?php

namespace Fabio\UltraAdmin\Framework;

abstract class ServiceProvider
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    // Questo metodo è pensato per registrare i servizi nel container
    public function register()
    {
        //
    }

    // Questo metodo è pensato per eseguire codice una volta che tutto è pronto
    public function boot()
    {
        //
    }
}
