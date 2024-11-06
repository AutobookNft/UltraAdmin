<?php

namespace App\Providers;

use App\Core\ServiceProvider;
use App\Config\LoggerConfig;
use App\Helpers\PathHelper;
use App\Framework\Router;
use Exception;

class AppServiceProvider extends ServiceProvider
{
    private array $loadedProviders = [];
    private $log;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->log = LoggerConfig::getLogger();
    }

    private function loadProviders(): void
    {
        try {
            $configPath = PathHelper::configPath('app.php');
            $providers = require $configPath;

            $this->log->info('Loading providers from: ' . $configPath);
            
            foreach ($providers['providers'] as $provider) {
                
                if (!class_exists($provider)) {
                    $this->log->error("Provider class not found: {$provider}");
                    continue;
                } else {
                    $this->log->info("Provider found: {$provider}");
                }
    
                if (basename(str_replace('\\', '/', $provider)) === 'RouteServiceProvider') {
                    $router = Router::getInstance();
                    $this->loadedProviders[$provider] = new $provider($router);
                    $this->log->info('Provider RouteServiceProvider registered');
                }else{  
                    $this->loadedProviders[$provider] = new $provider($this->app);
                }
                
            }
        } catch (Exception $e) {
            $this->log->error("Failed to load providers: " . $e->getMessage());
            throw $e;
        }
    }

    public function register(): void
    {
        try {
            if (empty($this->loadedProviders)) {
                $this->loadProviders();
            }

            $this->log->info('Loaded providers: ' . json_encode($this->loadedProviders));

            foreach ($this->loadedProviders as $provider) {
                
                if ($provider->getName() === 'RouteServiceProvider') {
                    $provider->boot();
                    $this->log->info('Booting provider: ' . $provider->getName());
                }else{
                    $provider->register();
                    $this->log->info('Registering provider: ' . $provider->getName());
                }
            }

        } catch (Exception $e) {
            $this->log->error("Failed to register providers: " . $e->getMessage());
            throw $e;
        }
    }

    public function boot(): void
    {
        $this->log->info('Kernel boot started');
    
        // ... per usi futuri
        
        $this->log->info('Kernel boot completed');
    }

    public function getName(): string
    {
        return 'AppServiceProvider';
    }
} 