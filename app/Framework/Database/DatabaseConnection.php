<?php

namespace App\Database\Framework;

use Fabio\UltraAdmin\Utils\EnvLoader;
use Fabio\UltraAdmin\Framework\Connect;
use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?PDO $connection = null;

    /**
     * Restituisce l'istanza di connessione PDO.
     *
     * @return PDO
     * @throws PDOException Se la connessione non può essere stabilita.
     */
    public static function getConnection(): PDO
    {
        // Controlla se la connessione esiste già, evita di ricrearla
        if (self::$connection === null) {
            try {
                
                $cn = Connect::get();
                // Creazione dell'istanza PDO
                self::$connection = new PDO(
                    "mysql:host={$cn['host']};dbname={$cn['dbname']}", 
                    $cn['username'], 
                    $cn['password'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );

            } catch (PDOException $e) {
                // Log dell'errore e gestione strutturata dell'eccezione
                error_log("Errore di connessione al database: " . $e->getMessage());
                throw new PDOException("Errore di connessione al database: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
