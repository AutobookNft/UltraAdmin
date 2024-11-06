<?php

return [
    'name' => 'UltraAdmin',
    
    'security' => [
        'enable_2fa' => true,
        'session_lifetime' => 120, // minuti
        'password_expiry_days' => 90,
        'max_login_attempts' => 5,
        'lockout_time' => 15, // minuti
    ],
    
    'logging' => [
        'channel' => 'ultra_stack',
        'level' => env('ULTRA_LOG_LEVEL', 'debug'),
        'max_files' => 30,
    ],
    
    'cache' => [
        'ttl' => 3600, // secondi
        'prefix' => 'ultra_',
    ],
    
    'api' => [
        'throttle' => [
            'max_attempts' => 60,
            'decay_minutes' => 1,
        ],
    ],
]; 