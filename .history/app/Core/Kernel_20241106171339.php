<?php

namespace App\Core;

use App\Core\Container;
use App\Framework\Router;
use App\Providers\AppServiceProvider;
use App\Config\LoggerConfig;

class Kernel
{
    protected Container $app;
    protected Router $router;
    protected $log;

    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->log = LoggerConfig::getLogger();
        $this->log->info('Kernel constructed');
    }

    /**
     * Avvia l'applicazione
     */
    public function boot(): void
    {
        $this->log->info('Kernel boot started');
        
        // Inizializza AppServiceProvider
        $appServiceProvider = new AppServiceProvider($this->app);
        $appServiceProvider->register();
        $appServiceProvider->boot();

        
        $this->router = $this->app->get(Router::class);
        
        $this->log->info('Kernel boot completed');
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

