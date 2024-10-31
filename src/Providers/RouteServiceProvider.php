<?php

namespace Fabio\UltraAdmin\Providers;

use Fabio\UltraAdmin\Framework\Router;
use LoggerConfig;

class RouteServiceProvider
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function register()
    {
        // Carica il file di definizione delle rotte
        $routeDefinitions = require __DIR__ . '/../../routes/web.php';

        // Esegui la funzione passandole l'istanza di Router
        $routeDefinitions($this->router);
    }

    public function boot()
    {
        $config = require __DIR__ . '/../../config/app.php';
        $log = LoggerConfig::getLogger();
        $log->info('RouteServiceProvider boot started');

        foreach ($config['routes'] as $routeFile) {
            if (file_exists($routeFile)) {
                $log->info("Loading route file: {$routeFile}");
                
                $routeInstance = require $routeFile;
                
                // Aggiunta del log per verificare il tipo di valore restituito
                $log->info("Tipo di valore restituito dal file delle rotte", ['type' => gettype($routeInstance)]);
                
                if ($routeInstance instanceof Router) {
                    $log->info("Router istanziato in RouteServiceProvider", ['routes' => $routeInstance->getRoutes()]);
                    
                    foreach ($routeInstance->getRoutes() as $method => $routes) {
                        foreach ($routes as $route => $handler) {
                            $this->router->addRoute($method, $route, $handler);
                            $log->info("Route aggiunta: {$method} {$route}");
                        }
                    }
                } else {
                    $log->error("Istanza di Router non valida");
                }
            } else {
                $log->error("Route file not found: {$routeFile}");
            }
        }
        
    }

}
