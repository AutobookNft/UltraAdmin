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
| Register Core Service Providers
|--------------------------------------------------------------------------
*/

// Registriamo AppServiceProvider come primo provider
$appProvider = new App\Providers\AppServiceProvider($app);
$appProvider->register();


/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
*/

return $app; 