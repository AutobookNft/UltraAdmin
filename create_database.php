<?php

require_once __DIR__ . '/vendor/autoload.php';


// Dati di configurazione del database

use Fabio\UltraAdmin\Framework\Connect;

$log = LoggerConfig::getLogger();

try {
    
    $log->info('Applicazione avviata con successo');
    
    // Dati di connessione al database
    $host = Connect::get()['host']; 
    $database = Connect::get()['dbname'];
    $username = Connect::get()['username'];
    $password = Connect::get()['password'];

    $log->info('Dati di Connessione al database', [
        'host' => $host,
        'database' => $database,
        'username' => $username,
        'password' => $password,
    ]);

    // Connessione al server MySQL senza specificare un database
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Creare il database se non esiste
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    $pdo->exec($sql);
    echo "Database $database creato con successo.<br>";

    // Connessione al database appena creato
    $pdo->exec("USE $database");

    // Creazione della tabella 'libraries'
    $tableSql = "
        CREATE TABLE IF NOT EXISTS libraries (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            version VARCHAR(50) NOT NULL,
            status VARCHAR(50) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";
    $pdo->exec($tableSql);
    echo "Tabella 'libraries' creata con successo.<br>";

} catch (PDOException $e) {

    $log->info('Errore nella creazione del database o della tabella', [
        'error' => $e->getMessage(),
    ]);

    echo "Errore nella creazione del database o della tabella: " . $e->getMessage();
}

