<?php

namespace 

use PDO;
use Fabio\UltraAdmin\Framework\Connect;
use Exception;

class LibraryRepository
{
    protected PDO $db;
    
    public function __construct()
    {
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
} 