<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\LibraryController;
use App\Core\Kernel;
use App\Core\Container;
use App\Providers\UltraAdminServiceProvider;
use App\Providers\AppServiceProvider;
use App\Framework\Router;
use App\Helpers\PathHelper;

// $home = __DIR__ . '/../../resources/views/home.html';

// Definisce il percorso di base dell'applicazione
PathHelper::setBasePath(__DIR__);

$log = LoggerConfig::getLogger();

$log->info('Applicazione avviata con successo');

// // Inizializza il container
$container = new Container();

$kernel = new Kernel($container);
$kernel->boot();
$kernel->dispatch();

$container->getSingletons();

$log->info('Fine applicazione');