<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = new App\Framework\Application(
    dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
*/

// Bind the base path
$app->singleton('path', function ($app) {
    return dirname(__DIR__) . '/app';
});

// Bind the config path
$app->singleton('path.config', function ($app) {
    return dirname(__DIR__) . '/config';
});

// Bind the storage path
$app->singleton('path.storage', function ($app) {
    return dirname(__DIR__) . '/storage';
});

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
*/

return $app; 