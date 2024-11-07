<?php

// routes/web.php

use App\Http\Controllers\LibraryController;
use App\Framework\Router;
use App\Helpers\PathHelper;
use App\Http\Controllers\Home;
use App\Config\LoggerConfig;
    
return function (Router $router)  {

    $log = LoggerConfig::getLogger();
    $log->info('dentro web.php');

    $home = new Home();
    $libraryController = new LibraryController();

    // Definiamo le route per LibraryController
    $router->addRoute('GET', '/', [$home, 'home']);
    $router->addRoute('GET', '/libraries', [$libraryController, 'index']);
    $router->addRoute('GET', '/libraries/create', [$libraryController, 'create']);
    $router->addRoute('POST', '/libraries/store', [$libraryController, 'store']);
    $router->addRoute('GET', '/libraries/edit/{id}', [$libraryController, 'edit']);
    $router->addRoute('POST', '/libraries/update/{id}', [$libraryController, 'update']);
    $router->addRoute('POST', '/libraries/delete', [$libraryController, 'delete']);

   
    $log->info('dopo le route');
    $log->info('Prima di restituire il router in web.php', ['routes' => $router->getRoutes()]);
};
