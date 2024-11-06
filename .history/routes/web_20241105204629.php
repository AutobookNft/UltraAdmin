<?php

// routes/web.php

use App\Http\Controllers\LibraryController;
use App\Framework\Router;
use App\Helpers\PathHelper;
use App\Http\Controllers\Home;
    
return function (Router $router)  {
    $libraryController = new LibraryController();
    $home = new Home();

    $log = LoggerConfig::getLogger();
    $log->info('dentro web.php');

    // Definiamo le route per LibraryController
    $router->addRoute('GET', '/', [$home, 'home']);
    $router->addRoute('GET', '/libraries', [LibraryController::class, 'index']);
    $router->addRoute('GET', '/libraries/create', [LibraryController::class, 'create']);
    $router->addRoute('POST', '/libraries/store', [LibraryController::class, 'store']);
    $router->addRoute('GET', '/libraries/edit', [LibraryController::class, 'edit']);
    $router->addRoute('POST', '/libraries/update', [LibraryController::class, 'update']);
    $router->addRoute('POST', '/libraries/delete', [LibraryController::class, 'delete']);

   
    $log->info('dopo le route');
    $log->info('Prima di restituire il router in web.php', ['routes' => $router->getRoutes()]);
};