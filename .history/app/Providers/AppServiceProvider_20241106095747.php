<?php

namespace App\Providers;

use App\Core\ServiceProvider;

use App\Config\LoggerConfig;

use App\Helpers\PathHelper;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $log = LoggerConfig::getLogger();

        // Trova il file di configurazione app.providers    
        $providers = PathHelper::configPath('app.');

        // Carica il file di configurazione app.providers
        // $providers = require $providers;

        $log->info('$providers: ' . json_encode($providers) );
        
        // foreach ($providers as $provider) {
        //     $providerInstance = new $provider($this->app);
        //     $providerInstance->register();
        // }
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