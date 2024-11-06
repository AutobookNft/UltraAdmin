   <?php

    // routes/web.php

    // Definiamo tutte le route qui per tenere il codice organizzato

    use App\Http\Controllers\LibraryController;
    use App\Framework\Router;
    
    use App\Config\LoggerConfig;
    $router = Router::getInstance();
$router->dispatch();

    $log = LoggerConfig::getLogger();
    $log->info('dentro api.php');

    $log->info('Prima di restituire il router in api.php', ['routes' => $router->getRoutes()]);

    return $router;