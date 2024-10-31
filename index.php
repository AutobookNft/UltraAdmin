<?php

require_once __DIR__ . '/vendor/autoload.php';

use Fabio\UltraAdmin\Controllers\LibraryController;
use Fabio\UltraAdmin\Core\Kernel;
use Fabio\UltraAdmin\Framework\Container;
use Fabio\UltraAdmin\Providers\UltraAdminServiceProvider;
use Fabio\UltraAdmin\Providers\AppServiceProvider;
use Fabio\UltraAdmin\Framework\Router;
use Fabio\UltraAdmin\Helpers\PathHelper;


// Definisce il percorso di base dell'applicazione
PathHelper::setBasePath(__DIR__);

$log = LoggerConfig::getLogger();

$log->info('Applicazione avviata con successo');

// // Inizializza il container
$container = new Container();

$kernel = new Kernel($container);
$kernel->boot();
// Esegue il routing della richiesta
$kernel->dispatch();

