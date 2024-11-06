<?php

namespace App\Core;

use App\Core\Container;
use App\Framework\Router;
use App\Providers\AppServiceProvider;

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
        $appServiceProvider = new AppServiceProvider($this->app);
        $appServiceProvider->register();
        $appServiceProvider->boot();

        // Recupera l'istanza di Router dal container e la salva in una proprietà
        // $this->router = $this->app->get(Router::class);
    }

    /**
     * Esegue il routing della richiesta corrente
     */
    public function dispatch(): void
    {
        $this->log->info('Kernel dispatch started');
        $this->router->dispatch();
        $this->log->info('Kernel dispatch completed');
    }
}

