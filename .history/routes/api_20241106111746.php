   <?php

    // routes/web.php

    // Definiamo tutte le route qui per tenere il codice organizzato

    use App\Http\Controllers\LibraryController;
    use App\Framework\Router;
    use App\Helpers\PathHelper;

    $router = new Router();

    $log = 
    $log->info('dentro api.php');

    $log->info('Prima di restituire il router in api.php', ['routes' => $router->getRoutes()]);

    return $router;