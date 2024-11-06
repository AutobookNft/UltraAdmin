<?php

return [
    'providers' => [
        Fabio\UltraAdmin\Providers\UltraAdminServiceProvider::class,
        Fabio\UltraAdmin\Providers\RouteServiceProvider::class,
        Fabio\UltraAdmin\Providers\UConfigServiceProvider::class,
        Fabio\UltraAdmin\Providers\UltraAdminServiceProvider::class,
        Fabio\UltraAdmin\Providers\TranslationServiceProvider::class,



        // Aggiungi qui altri providers se necessario
    ],
    'routes' => [
        'web' => __DIR__ . '/../routes/web.php',
        'api' => __DIR__ . '/../routes/api.php',
        // Aggiungi altri file di route
    ],
];
