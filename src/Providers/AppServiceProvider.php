<?php

namespace Fabio\UltraAdmin\Providers;

use Fabio\UltraAdmin\Framework\Container;
use Fabio\UltraAdmin\Framework\Router;

class AppServiceProvider
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
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
                $provider = new $providerClass($this->container);
            }

            if (method_exists($provider, 'register')) {
                $provider->register();
            }
            $provider->boot();
        }

        // Salva l'istanza di Router nel container per accessi successivi
        $this->container->bind(Router::class, fn() => $router);
    }
}
