<?php

namespace App\Providers;

use App\Core\ServiceProvider;
use App\Core\DatabaseManager;
use App\Core\DatabaseManagerInterface;
use App\Framework\DatabaseConnection;

class DatabaseServiceProvider extends ServiceProvider
{
    public function getName(): string
    {
        return 'DatabaseServiceProvider';
    }

    public function register()
    {
        // Ottieni la connessione PDO dal DatabaseConnection
        $this->app->singleton(DatabaseConnection::class, function($app) {
            return new DatabaseConnection();
        });

        // Registra il DatabaseManager con la connessione PDO
        $this->app->singleton(DatabaseManagerInterface::class, function($app) {
            $connection = $app->make(DatabaseConnection::class)->getConnection();
            return new DatabaseManager($connection);
        });
    }
} 