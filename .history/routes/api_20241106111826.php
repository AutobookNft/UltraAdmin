   <?php

    // routes/web.php

    // Definiamo tutte le route qui per tenere il codice organizzato

    use App\Http\Controllers\LibraryController;
    use App\Framework\Router;
    use App\Helpers\PathHelper;
    use App\Config\LoggerConfig;
    $router = new Router();

    $log = LoggerConfig::getLogger();
    $log->info('dentro api.php');

    $log->info('Prima di restituire il router in api.php', ['routes' => $router->getRoutes()]);

    return $router;