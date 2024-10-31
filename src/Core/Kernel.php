<?php

namespace Fabio\UltraAdmin\Core;

use Fabio\UltraAdmin\Framework\Container;
use Fabio\UltraAdmin\Framework\Router;
use Fabio\UltraAdmin\Providers\AppServiceProvider;

class Kernel
{
    protected Container $container;
    protected Router $router;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Avvia l'applicazione
     */
    public function boot(): void
    {
        // Inizializza AppServiceProvider, che si occuperà di registrare tutti i provider
        $appServiceProvider = new AppServiceProvider($this->container);
        $appServiceProvider->boot();

         // Recupera l'istanza di Router dal container e salva in una proprietà
         $this->router = $this->container->get(Router::class);
    }

    public function dispatch(): void
    {
        // Esegue il router per instradare la richiesta
        $this->router->dispatch();
    }
}

