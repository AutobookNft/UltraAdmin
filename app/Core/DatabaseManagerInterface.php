<?php

namespace App\Core;

use PDO;
use PDOException;

interface DatabaseManagerInterface
{
    /**
     * Ottiene l'istanza di PDO.
     *
     * @return PDO
     * @throws PDOException
     */
    public function getConnection(): PDO;

    /**
     * Esegue una query SQL con parametri opzionali.
     *
     * @param string $query La query SQL da eseguire.
     * @param array $params Parametri per la query.
     * @return PDOStatement
     * @throws PDOException
     */
    public function query(string $query, array $params = []): \PDOStatement;

    /**
     * Inizia una transazione.
     *
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * Commette una transazione.
     *
     * @return void
     */
    public function commit(): void;

    /**
     * Annulla una transazione.
     *
     * @return void
     */
    public function rollBack(): void;
} 