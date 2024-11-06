<?php

namespace App\Providers;

use aPPFramework\Router;
use LoggerConfig;

class RouteServiceProvider
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Carica e registra le rotte definite nei file di configurazione
     */
    public function boot()
    {
        // Recupera il file di configurazione app.php che contiene i path dei file di rotte
        $config = require __DIR__ . '/../../config/app.php';
        
        $log = LoggerConfig::getLogger();
        $log->info('RouteServiceProvider boot started');

        // Itera sui file di configurazione delle rotte
        foreach ($config['routes'] as $routeFile) {
            if (file_exists($routeFile)) {
                $log->info("Loading route file: {$routeFile}");

                // Carica il file di rotte e verifica se restituisce una closure
                $routeLoader = require $routeFile;

                // Se il file di rotte restituisce una closure, eseguila e passa il Router
                if (is_callable($routeLoader)) {
                    $routeLoader($this->router);
                    $log->info("Routes registered from: {$routeFile}", ['routes' => $this->router->getRoutes()]);
                } else {
                    $log->error("Il file delle rotte non ha restituito una funzione valida.");
                }
            } else {
                $log->error("Route file not found: {$routeFile}");
            }
        }
    }
}
