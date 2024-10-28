<?php

namespace Fabio\UltraAdmin\Models;

use Fabio\UltraAdmin\Utils\EnvLoader;
use PDO;
use PDOException;

class Library
{
    private static ?PDO $connection = null;
    public int $id;
    public string $name;
    public string $description;
    public string $version;

    /**
     * Costruttore per inizializzare i dati della libreria
     */
    public function __construct(string $name = '', string $description = '', string $version = '')
    {
        $this->name = $name;
        $this->description = $description;
        $this->version = $version;
    }

    /**
     * Ottiene la connessione al database.
     *
     * @return PDO
     */
    private static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                $host = EnvLoader::get('DB_HOST', 'localhost');
                $dbname = EnvLoader::get('DB_NAME', 'ultra_admin');
                $username = EnvLoader::get('DB_USER', 'root');
                $password = EnvLoader::get('DB_PASSWORD', '');
    
                $dsn = "mysql:host=$host;dbname=$dbname";
                self::$connection = new PDO($dsn, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Errore di connessione: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }

    /**
     * Recupera tutte le librerie dal database.
     *
     * @return array
     */
    public static function all(): array
    {
        $conn = self::getConnection();
        $stmt = $conn->query('SELECT * FROM libraries');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Trova una libreria per ID.
     *
     * @param int $id
     * @return Library|null
     */
    public static function find(int $id): ?Library
    {
        $conn = self::getConnection();
        $stmt = $conn->prepare('SELECT * FROM libraries WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $library = $stmt->fetchObject(self::class);
        return $library ?: null;
    }

    /**
     * Salva la libreria nel database (crea una nuova o aggiorna esistente).
     *
     * @return void
     */
    public function save(): void
    {
        $conn = self::getConnection();

        if (isset($this->id) && $this->id > 0) {
            // Aggiornamento di una libreria esistente
            $stmt = $conn->prepare('UPDATE libraries SET name = :name, description = :description, version = :version WHERE id = :id');
            $stmt->execute([
                'name' => $this->name,
                'description' => $this->description,
                'version' => $this->version,
                'id' => $this->id
            ]);
        } else {
            // Creazione di una nuova libreria
            $stmt = $conn->prepare('INSERT INTO libraries (name, description, version) VALUES (:name, :description, :version)');
            $stmt->execute([
                'name' => $this->name,
                'description' => $this->description,
                'version' => $this->version
            ]);

            // Imposta l'ID per l'oggetto corrente
            $this->id = $conn->lastInsertId();
        }
    }

    /**
     * Elimina la libreria dal database.
     *
     * @return void
     */
    public function delete(): void
    {
        if (isset($this->id) && $this->id > 0) {
            $conn = self::getConnection();
            $stmt = $conn->prepare('DELETE FROM libraries WHERE id = :id');
            $stmt->execute(['id' => $this->id]);
        }
    }
}
