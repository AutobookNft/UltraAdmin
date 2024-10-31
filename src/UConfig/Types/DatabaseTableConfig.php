<?php

namespace Fabio\UltraAdmin\UConfig\Types;

use Fabio\UltraAdmin\UConfig\Contracts\ConfigInterface;
use PDO;

class DatabaseTableConfig
{
    protected array $config = [];
    protected PDO $dbConnection;
    protected string $tableName;
    protected array $excludedFields = ['id', 'created_at', 'updated_at'];

    public function __construct(PDO $dbConnection, string $tableName)
    {
        $this->dbConnection = $dbConnection;
        $this->tableName = $tableName;
        $this->load();
    }

    /**
     * Carica i dati di configurazione dalla tabella del database
     *
     * @return array
     */
    public function load(): array
    {
        $query = "SELECT config_key, config_value FROM {$this->tableName}";
        $stmt = $this->dbConnection->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            $this->config[$row['config_key']] = $row['config_value'];
        }

        $this->validate();
        return $this->config;
    }

    /**
     * Ottiene dinamicamente lo schema della tabella escludendo campi specifici.
     *
     * @return array
     */
    public function getSchema(): array
    {
        $schema = [];

        // Query per ottenere i metadati delle colonne
        $query = "SELECT COLUMN_NAME, DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = :tableName AND TABLE_SCHEMA = DATABASE()";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':tableName', $this->tableName);
        $stmt->execute();

        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($columns as $column) {
            $columnName = $column['COLUMN_NAME'];

            // Esclude i campi non desiderati
            if (in_array($columnName, $this->excludedFields)) {
                continue;
            }

            // Mappa il tipo di dato MySQL in un tipo di dato PHP
            $schema[$columnName] = $this->mapDatabaseTypeToPHPType($column['DATA_TYPE']);
        }

        return $schema;
    }

    /**
     * Mappa i tipi di dato del database a tipi di dato PHP
     *
     * @param string $databaseType
     * @return string
     */
    protected function mapDatabaseTypeToPHPType(string $databaseType): string
    {
        return match ($databaseType) {
            'int', 'tinyint', 'smallint', 'mediumint', 'bigint' => 'integer',
            'decimal', 'float', 'double' => 'double',
            'varchar', 'text', 'char' => 'string',
            'bool', 'boolean' => 'boolean',
            default => 'string', // Tipo di default
        };
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

    public function getConfigValue(string $key)
    {
        return $this->config[$key] ?? null;
    }
}
