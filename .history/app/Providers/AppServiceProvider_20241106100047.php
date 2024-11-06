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
        $providers = PathHelper::configPath('app.php');

        // Carica il file di configurazione app.providers
        $providers = require $providers;
  
        foreach ($providers as $provider) {
            $log->info('$providers: ' . json_encode($provider) );
            <?php echo ""
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