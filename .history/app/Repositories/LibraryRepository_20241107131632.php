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

    public function saveLibrary($data)
    {
        try {
            $query = "INSERT INTO libraries (
                name, version, status, description, 
                author, repository_url, documentation_url, 
                license, dependencies, tags
            ) VALUES (
                :name, :version, :status, :description,
                :author, :repository_url, :documentation_url,
                :license, :dependencies, :tags
            )";

            $stmt = $this->db->prepare($query);
            
            $params = [
                ':name' => htmlspecialchars($data['name']),
                ':version' => htmlspecialchars($data['version']),
                ':status' => htmlspecialchars($data['status'] ?? 'active'),
                ':description' => htmlspecialchars($data['description'] ?? ''),
                ':author' => htmlspecialchars($data['author'] ?? ''),
                ':repository_url' => htmlspecialchars($data['repository_url'] ?? ''),
                ':documentation_url' => htmlspecialchars($data['documentation_url'] ?? ''),
                ':license' => htmlspecialchars($data['license'] ?? ''),
                ':dependencies' => htmlspecialchars($data['dependencies'] ?? ''),
                ':tags' => htmlspecialchars($data['tags'] ?? '')
            ];

            $stmt->execute($params);
            return $this->db->lastInsertId();
            
        } catch (Exception $e) {
            $this->log->error('Errore nel salvataggio della libreria:', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw new Exception("Errore nel salvataggio della libreria: " . $e->getMessage());
        }
    }
    
    public function update($id, array $data)
    {
        try {
            $this->log->info('Update chiamato con:', ['id' => $id, 'data' => $data]);

            $query = "UPDATE libraries SET 
                name = :name,
                version = :version,
                status = :status,
                description = :description,
                author = :author,
                repository_url = :repository_url,
                documentation_url = :documentation_url,
                license = :license,
                dependencies = :dependencies,
                tags = :tags,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

            $stmt = $this->db->prepare($query);
            
            $params = [
                ':id' => (int)$id,
                ':name' => htmlspecialchars($data['name']),
                ':version' => htmlspecialchars($data['version']),
                ':status' => htmlspecialchars($data['status'] ?? 'active'),
                ':description' => htmlspecialchars($data['description'] ?? ''),
                ':author' => htmlspecialchars($data['author'] ?? ''),
                ':repository_url' => htmlspecialchars($data['repository_url'] ?? ''),
                ':documentation_url' => htmlspecialchars($data['documentation_url'] ?? ''),
                ':license' => htmlspecialchars($data['license'] ?? ''),
                ':dependencies' => htmlspecialchars($data['dependencies'] ?? ''),
                ':tags' => htmlspecialchars($data['tags'] ?? '')
            ];

            $this->log->info('Parametri update:', ['params' => $params]);
            
            $success = $stmt->execute($params);
            
            if (!$success) {
                throw new Exception("Errore nell'aggiornamento della libreria");
            }
            
            return $this->getLibraryById($id);
            
        } catch (Exception $e) {
            $this->log->error('Errore in update:', [
                'error' => $e->getMessage(),
                'id' => $id,
                'data' => $data
            ]);
            throw $e;
        }
    }

    // Metodo helper per validare i dati
    private function validateLibraryData($data)
    {
        $required = ['name', 'version', 'status'];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("Campo obbligatorio mancante: {$field}");
            }
        }
        
        // Validazione URL
        if (!empty($data['repository_url']) && !filter_var($data['repository_url'], FILTER_VALIDATE_URL)) {
            throw new Exception("URL repository non valido");
        }
        
        if (!empty($data['documentation_url']) && !filter_var($data['documentation_url'], FILTER_VALIDATE_URL)) {
            throw new Exception("URL documentazione non valido");
        }
        
        // Validazione status
        $validStatuses = ['active', 'deprecated', 'maintenance', 'development'];
        if (!in_array($data['status'], $validStatuses)) {
            throw new Exception("Stato non valido");
        }
    }
} 