<?php

// routes/web.php

use App\Http\Controllers\LibraryController;
use App\Framework\Router;
use App\Helpers\PathHelper;

return function (Router $router)  {
    $libraryController = new LibraryController();
    

    $log = LoggerConfig::getLogger();
    $log->info('dentro web.php');

    // Definiamo le route per LibraryController
    $router->addRoute('GET', '/', [$libraryController, 'home']);
    $router->addRoute('GET', '/libraries', [$libraryController, 'index']);
    $router->addRoute('GET', '/libraries/create', [$libraryController, 'create']);
    $router->addRoute('POST', '/libraries/store', [$libraryController, 'store']);
    $router->addRoute('GET', '/libraries/edit', [$libraryController, 'edit']);
    $router->addRoute('POST', '/libraries/update', [$libraryController, 'update']);
    $router->addRoute('POST', '/libraries/delete', [$libraryController, 'delete']);

   
    $log->info('dopo le route');
    $log->info('Prima di restituire il router in web.php', ['routes' => $router->getRoutes()]);
};
