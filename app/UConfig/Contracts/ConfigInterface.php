<?php

// src/Config/Contracts/ConfigInterface.php
namespace App\UConfig\Contracts;

interface ConfigInterface
{
    /**
     * Carica i dati di configurazione.
     */
    public function load(): array;

    /**
     * Valida i dati di configurazione in base a uno schema.
     */
    public function validate(): bool;

    /**
     * Restituisce lo schema di validazione per questa configurazione.
     */
    public function getSchema(): array;

    /**
     * Restituisce il valore di configurazione per una chiave specifica.
     */
    public function getConfigValue(string $key);
}
