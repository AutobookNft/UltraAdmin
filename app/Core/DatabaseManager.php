<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Config\LoggerConfig;

class DatabaseManager implements DatabaseManagerInterface
{
    protected PDO $connection;
    protected $log;

    /**
     * Costruttore che inietta la dipendenza della connessione PDO.
     *
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->log = LoggerConfig::getLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * {@inheritdoc}
     */
    public function query(string $query, array $params = []): \PDOStatement
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            $this->log->info('Esecuzione query', ['query' => $query, 'params' => $params]);
            return $stmt;
        } catch (PDOException $e) {
            $this->log->error('Errore nell\'esecuzione della query', ['error' => $e->getMessage(), 'query' => $query]);
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
        $this->log->info('Inizio transazione');
    }

    /**
     * {@inheritdoc}
     */
    public function commit(): void
    {
        $this->connection->commit();
        $this->log->info('Commetta transazione');
    }

    /**
     * {@inheritdoc}
     */
    public function rollBack(): void
    {
        $this->connection->rollBack();
        $this->log->info('Rollback transazione');
    }
} 