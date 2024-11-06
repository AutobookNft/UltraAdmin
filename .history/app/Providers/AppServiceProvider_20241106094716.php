<?php

namespace App\Providers;

use App\Core\ServiceProvider;
use App\Framework\Router;
use App\Config\LoggerConfig;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $log = LoggerConfig::getLogger();

        // Carica i providers dalla configurazione
        $providers = 
        $log->info('$providers: ' . json_encode($providers) );
        
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