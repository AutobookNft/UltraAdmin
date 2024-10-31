<?php

namespace Fabio\UltraAdmin\Framework;

use Fabio\UltraAdmin\Utils\EnvLoader;
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
                $host = EnvLoader::get('DB_HOST', 'localhost');
                $dbname = EnvLoader::get('DB_NAME', 'ultra_admin');
                $username = EnvLoader::get('DB_USER', '');
                $password = EnvLoader::get('DB_PASSWORD', 'Hillbert9#');
                
                // Creazione dell'istanza PDO
                self::$connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                // Log dell'errore o gestione eccezione
                throw new PDOException("Errore di connessione al database: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
