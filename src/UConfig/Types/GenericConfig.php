<?php

namespace Fabio\UltraAdmin\UConfig\Types;

/**
 * Classe GenericConfig
 * 
 * Questa classe offre una soluzione flessibile e generica per la gestione di configurazioni
 * che possono variare in struttura e contenuto. A differenza delle classi che implementano
 * l'interfaccia ConfigInterface, GenericConfig non aderisce a requisiti rigidi, rendendola
 * ideale per configurazioni di librerie di terze parti o per scenari che non richiedono una 
 * logica di validazione altamente specifica.
 * 
 * Utilizza percorsi di file per caricare dinamicamente la configurazione e lo schema di 
 * validazione, supportando un'ampia gamma di configurazioni senza dover creare nuove classi
 * per ogni libreria o modulo. È possibile caricare sia la configurazione sia lo schema da 
 * file separati, con validazione dei tipi di dati su base configurabile.
 * 
 * Metodi principali:
 * - __construct(): accetta i percorsi per i file di configurazione e di schema.
 * - load(): ritorna i dati di configurazione.
 * - validate(): verifica che la configurazione rispetti i tipi definiti nello schema.
 * - getConfigValue(): ottiene valori annidati nella configurazione tramite chiavi dot-separated.
 * 
 * Questa classe è particolarmente utile per:
 * - Integrare librerie di terzi senza dover creare nuove classi di configurazione.
 * - Gestire configurazioni non strettamente ortodosse rispetto all'architettura principale.
 * 
 * Esempio d'uso:
 * $genericConfig = new GenericConfig('/path/to/config.php', '/path/to/schema.php');
 * $configData = $genericConfig->load();
 * $genericConfig->validate();
 * 
 * @package Fabio\UltraAdmin\UConfig\Types
 */
class GenericConfig
{
    protected array $config = [];
    protected array $schema = [];

    public function __construct(string $configFilePath, string $schemaFilePath)
    {
        $this->loadConfig($configFilePath);
        $this->loadSchema($schemaFilePath);
    }

    /**
     * Carica la configurazione da un file specifico.
     *
     * @param string $filePath
     * @return array
     */
    protected function loadConfig(string $filePath): array
    {
        $this->config = require $filePath;
        return $this->config;
    }

    /**
     * Carica lo schema di validazione da un file specifico.
     *
     * @param string $filePath
     * @return array
     */
    protected function loadSchema(string $filePath): array
    {
        $this->schema = require $filePath;
        return $this->schema;
    }

    public function load(): array
    {
        return $this->config;
    }

    public function validate(): bool
    {
        foreach ($this->schema as $key => $type) {
            $value = $this->getConfigValue($key);
            if (gettype($value) !== $type) {
                throw new \Exception("Errore di validazione: {$key} deve essere di tipo {$type}");
            }
        }
        return true;
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
