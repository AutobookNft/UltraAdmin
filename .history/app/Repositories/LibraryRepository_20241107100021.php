<?php

namespace App\Repositories;

use PDO;
use App\Framework\Database\Connect;
use App\Config\LoggerConfig;
use Exception;

class LibraryRepository
{
    protected PDO $db;
    protected $log;
    public function __construct()
    {
        $this->log = LoggerConfig::getLogger();
        
        try {
            $config = Connect::get();
            $this->db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config['username'],
                $config['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (Exception $e) {
            throw new Exception("Errore di connessione al database: " . $e->getMessage());
        }
    }

    public function getAllLibraries(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM libraries ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Errore nel recupero delle librerie: " . $e->getMessage());
        }
    }

    public function getLibraryById($id)
    {
        // Implementa la logica per ottenere una libreria per ID
        try {
            $stmt = $this->db->prepare("SELECT * FROM libraries WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Errore nel recupero della libreria: " . $e->getMessage());
        }
    }

    public function saveLibrary($name, $description, $version)
    {
        // Implementa la logica per salvare una libreria
        try {
            $stmt = $this->db->prepare("INSERT INTO libraries (name, description, version) VALUES (:name, :description, :version)");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':version', $version, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Errore nella salva della libreria: " . $e->getMessage());
        }
    }
    
    public function updateLibrary($id, $name, $description, $version)
    {
        
        
        // Implementa la logica per aggiornare una libreria
        try {
            $stmt = $this->db->prepare("UPDATE libraries SET name = :name, description = :description, version = :version WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':version', $version, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Errore nell'aggiornamento della libreria: " . $e->getMessage());
        }
    }   
} 