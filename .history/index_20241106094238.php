<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Kernel;
use App\Core\Container;
use App\Helpers\PathHelper;
use App\Config\LoggerConfig;

// $home = __DIR__ . '/../../resources/views/home.html';

// Definisce il percorso di base dell'applicazione
PathHelper::setBasePath(__DIR__);

$log = LoggerConfig::getLogger();
$log->info('Applicazione avviata con successo');

// // Inizializza il container
$container = new Container();
$log->info('Container');

$kernel = new Kernel($container);
$log->info('Kernel');
$kernel->boot();
$log
$log->info('Kernel booted');
$kernel->dispatch();

$container->getSingletons();

$log->info('Fine applicazione');