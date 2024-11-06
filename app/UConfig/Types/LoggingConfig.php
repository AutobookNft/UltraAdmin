<?php

// src/Config/Types/LoggingConfig.php
namespace App\UConfig\Types;

use App\UConfig\Contracts\ConfigInterface;

class LoggingConfig implements ConfigInterface
{
    protected array $config = [];

    public function load(): array
    {
        $this->config = require __DIR__ . '/../../../config/logging.php';
        return $this->config;
    }

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

    public function getSchema(): array
    {
        return [
            'default' => 'string',
            'channels' => 'array',
            'channels.single.driver' => 'string',
            'channels.single.path' => 'string',
            'channels.single.level' => 'string',
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
