<?php

namespace App\Framework;

use App\Config\LoggerConfig;

class Router
{
    private static ?Router $instance = null;
    private array $routes = [];

    public static function getInstance(): Router
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {}

    /**
     * Registra una route associandola a una funzione o metodo.
     *
     * @param string $method
     * @param string $path
     * @param callable $handler
     */
    public function addRoute(string $method, string $path, callable $handler): void
    {
        $this->routes[strtoupper($method)][$path] = $handler;
        $log = LoggerConfig::getLogger();
        $log->info('dentro Router.php addRoute key:', ['handler' => $this->routes[strtoupper($method)][$path]]);
        
    }

    /**
     * Esegue la route corrispondente in base alla richiesta corrente.
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $log = LoggerConfig::getLogger();
        $log->info('Router dispatch', [
            'method' => $method,
            'path' => $path,
            'available_routes' => array_keys($this->routes[$method] ?? [])
        ]);

        // Cerca una route che corrisponda
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            // Converti il pattern della route in una regex
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
            $pattern = '@^' . $pattern . '$@D';
            
            // Verifica se il path corrisponde al pattern
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Rimuove il match completo
                
                $log->info('Route matched', [
                    'pattern' => $pattern,
                    'matches' => $matches
                ]);
                
                // Chiama l'handler con i parametri estratti
                call_user_func_array($handler, $matches);
                return;
            }
        }

        // Se non trova corrispondenze
        http_response_code(404);
        echo "404 - Pagina non trovata.";
    }
    
    /**
     * Restituisce tutte le rotte registrate.
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

}

