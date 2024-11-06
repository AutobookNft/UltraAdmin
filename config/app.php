<?php

return [
    'providers' => [
        // App\Providers\UltraAdminServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\UConfigServiceProvider::class,
        App\Providers\TranslationServiceProvider::class,


        // Aggiungi qui altri providers se necessario
    ],
    'routes' => [
        'web' => __DIR__ . '/../routes/web.php',
        'api' => __DIR__ . '/../routes/api.php',
        // Aggiungi altri file di route
    ],
];
