<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Kernel;
use App\Core\Container;
use App\Helpers\PathHelper;
use App\Config\LoggerConfig;


$log = LoggerConfig::getLogger();
$log->info('Applicazione avviata con successo');


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