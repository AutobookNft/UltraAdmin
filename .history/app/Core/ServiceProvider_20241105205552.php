<?php

namespace App\Core;

use App\Core\Container;
use App\Framework\Router;
use App\Core\RouteServiceProvider;

class ServiceProvider
{
    protected Container $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Avvia tutti i provider registrati
     */
    public function boot()
    {
        $config = require __DIR__ . '/../../config/app.php';

        // Crea un'istanza di Router da usare con RouteServiceProvider
        $router = new Router();

        foreach ($config['providers'] as $providerClass) {
            if ($providerClass === RouteServiceProvider::class) {
                // Passa l'istanza di Router a RouteServiceProvider
                $provider = new $providerClass($router);
            } else {
                // Passa l'istanza di Container agli altri provider
                $provider = new $providerClass($this->app);
            }

            if (method_exists($provider, 'register')) {
                $provider->register();
            }
            if (method_exists($provider, 'boot')) {
                $provider->boot();
            }
        }

        // Salva l'istanza di Router nel container per accessi successivi
        $this->app->bind(Router::class, fn() => $router, true);
    }
}
