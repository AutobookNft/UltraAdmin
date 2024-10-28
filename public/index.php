<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fabio\UltraAdmin\Controllers\LibraryController;
use Fabio\UltraAdmin\Framework\Container;
use Fabio\UltraAdmin\Providers\UltraAdminServiceProvider;
use Fabio\UltraAdmin\Utils\EnvLoader;

// Inizializza il container
$container = new Container();

// Inizializza e registra il service provider
$provider = new UltraAdminServiceProvider($container);
$provider->register();
$provider->boot();

// Risolvi il LibraryController utilizzando il container, sfruttando l'autowiring
$libraryController = $container->resolve(LibraryController::class);

// Avvio del metodo index per il LibraryController
$libraryController->index();

// Carica le variabili dal file .env
EnvLoader::load(__DIR__ . '/../.env');