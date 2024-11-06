<?php

namespace App\Facades;

use App\UConfig\UConfig;

class UConfigFacade
{
    /**
     * Accede a un valore di configurazione tramite notazione dot-separated.
     *
     * @param string $key La chiave di configurazione, es. "database.connections.mysql.host"
     * @return mixed Il valore della configurazione richiesta
     * @throws \Exception
     */
    public static function get(string $key)
    {
        // Divide la chiave in tipo di configurazione e chiave annidata
        $parts = explode('.', $key, 2);
        $configType = $parts[0];
        $configKey = $parts[1] ?? null;

        // Carica la configurazione usando UConfig
        $configInstance = UConfig::load($configType);

        // Ritorna il valore annidato se la chiave esiste, o l'intera configurazione se non specificata
        return $configKey ? $configInstance->getConfigValue($configKey) : $configInstance->load();
    }
}
