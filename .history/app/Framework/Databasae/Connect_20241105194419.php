<?php

namespace App\Database\Framework;

use Fabio\UltraAdmin\Utils\EnvLoader;

// Carica le variabili dal file .env
EnvLoader::load(__DIR__ . '/../../.env');

class Connect
{
    /**
     * Restituisce i dati di connessione per il database.
     *
     * @return array
     */
    public static function get(): array
    {
        return [
            'host' => EnvLoader::get('DB_HOST', 'localhost'),
            'dbname' => EnvLoader::get('DB_NAME', 'ultra_admin'),
            'username' => EnvLoader::get('DB_USER', ''),
            'password' => EnvLoader::get('DB_PASSWORD', 'Hillbert9#'),
        ];
    }
}