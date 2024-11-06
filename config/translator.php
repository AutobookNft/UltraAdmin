<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | Questa è la lingua predefinita utilizzata dall'applicazione quando
    | non viene specificata esplicitamente una lingua diversa.
    |
    */
    'default_locale' => 'it',

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    |
    | Questa è la lingua di fallback utilizzata quando la traduzione
    | nella lingua principale non è disponibile.
    |
    */
    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Available Locales
    |--------------------------------------------------------------------------
    |
    | Lista delle lingue supportate dall'applicazione.
    |
    */
    'available_locales' => ['it', 'en', 'es', 'fr', 'de'],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Configurazione della cache per le traduzioni.
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // tempo in secondi
    ],
]; 