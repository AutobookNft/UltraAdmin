<?php

namespace App\Core;

use App\Core\Container;
use App\Framework\Router;
use App\Providers\RouteServiceProvider;
use App\Helpers\PathHelper;

abstract class ServiceProvider
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

    protected function publishes(array $paths, $groups = null)
    {
        // Crea la directory config se non esiste
        if (!file_exists(PathHelper::configPath())) {
            mkdir(PathHelper::configPath(), 0755, true);
        }

        // Copia ogni file nella sua destinazione
        foreach ($paths as $from => $to) {
            if (file_exists($from)) {
                copy($from, $to);
            }
        }
    }

    protected function loadRoutesFrom($path)
    {
        if (file_exists($path)) {
            require $path;
        }
    }

    protected function loadViewsFrom($directory, $namespace)
    {
        if (!isset($this->app->viewPaths)) {
            $this->app->viewPaths = [];
        }
        $this->app->viewPaths[$namespace] = $directory;
    }

    protected function loadMigrationsFrom($path)
    {
        $this->app->migrationPaths[] = $path;
    }

    abstract public function getName(): string;
    {
        
    }
}
