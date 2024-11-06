<?php

namespace App\Providers;

use App\Core\ServiceProvider;
use App\Framework\Router;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registra il Router come singleton speciale
        $this->app->singleton('router', function($app) {
            return new Router();
        });

        // Carica i providers dalla configurazione
        $providers = $this->app->config['app']['providers'] ?? [];
        
        
        foreach ($providers as $provider) {
            $providerInstance = new $provider($this->app);
            $providerInstance->register();
        }
    }

    public function boot(): void
    {
        // Esegue il boot di tutti i providers registrati
        $providers = $this->app->config['app']['providers'] ?? [];
        
        foreach ($providers as $provider) {
            $providerInstance = new $provider($this->app);
            $providerInstance->boot();
        }
    }
} 