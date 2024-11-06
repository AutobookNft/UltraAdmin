<?php

namespace App\UConfig\Types;

use App\UConfig\Contracts\ConfigInterface;
use App\Utils\EnvLoader;

class DatabaseConfig implements ConfigInterface
{
    protected array $config = [];

    /**
     * Carica la configurazione del database
     *
     * @return array
     */
    public function load(): array
    {
        $this->config = [
            'default' => EnvLoader::get('DB_CONNECTION', 'mysql'),
            'connections' => [
                'mysql' => [
                    'host' => EnvLoader::get('DB_HOST', '127.0.0.1'),
                    'port' => (int) EnvLoader::get('DB_PORT', 3306),
                    'database' => EnvLoader::get('DB_DATABASE', 'your_database'),
                    'username' => EnvLoader::get('DB_USERNAME', 'your_username'),
                    'password' => EnvLoader::get('DB_PASSWORD', 'your_password'),
                ],
            ],
        ];

        return $this->config;
    }

    /**
     * Valida la configurazione del database
     *
     * @return bool
     * @throws \Exception
     */
    public function validate(): bool
    {
        $schema = $this->getSchema();

        foreach ($schema as $key => $type) {
            $value = $this->getConfigValue($key);
            if (gettype($value) !== $type) {
                throw new \Exception("Errore di validazione: {$key} deve essere di tipo {$type}");
            }
        }

        return true;
    }

    /**
     * Restituisce lo schema di validazione per la configurazione del database
     *
     * @return array
     */
    public function getSchema(): array
    {
        return [
            'default' => 'string',
            'connections.mysql.host' => 'string',
            'connections.mysql.port' => 'integer',
            'connections.mysql.database' => 'string',
            'connections.mysql.username' => 'string',
            'connections.mysql.password' => 'string',
        ];
    }

    public function getConfigValue(string $key)
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $k) {
            $value = $value[$k] ?? null;
        }

        return $value;
    }
}
