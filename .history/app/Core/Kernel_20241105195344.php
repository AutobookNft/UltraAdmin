<?php

namespace App\Core;

use App\Core\Container;
use App\Framework\Router;
use App\Providers\ServiceProvider;

class Kernel
{
    protected Container $app;
    protected Router $router;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Avvia l'applicazione
     */
    public function boot(): void
    {
        // Inizializza AppServiceProvider, che si occuperà di registrare tutti i provider
        $appServiceProvider = new ServiceProvider($this->app);
        $appServiceProvider->boot();

        // Recupera l'istanza di Router dal container e la salva in una proprietà
        $this->router = $this->app->get(Router::class);
    }

    /**
     * Esegue il routing della richiesta corrente
     */
    public function dispatch(): void
    {
        // Esegue il router per instradare la richiesta
        $this->router->dispatch();
    }
}

