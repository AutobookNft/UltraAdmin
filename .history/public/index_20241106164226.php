<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Kernel;
use App\Core\Container;
use App\Helpers\PathHelper;
use App\Config\LoggerConfig;

// // Definisce il percorso di base dell'applicazione
// PathHelper::setBasePath(__DIR__);

$log = LoggerConfig::getLogger();
$log->info('Applicazione avviata con successo');

// // Inizializza il container
// $container = new Container();
// $kernel = new Kernel($container);
// $kernel->boot();
// $kernel->dispatch();
// $container->getSingletons();

/*
|--------------------------------------------------------------------------
| Bootstrap The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$kernel = new Kernel($app);
$kernel->boot();
$kernel->dispatch();

// Debug info
$app->getSingletons(); 