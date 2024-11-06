<?php

namespace App\Providers;

use App\Core\ServiceProvider;
use App\Config\LoggerConfig;
use App\Helpers\PathHelper;
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

            $THIS->LOG
            
            foreach ($providers as $provider) {
                if (!class_exists($provider)) {
                    $this->log->error("Provider class not found: {$provider}");
                    continue;
                }

                $this->loadedProviders[$provider] = new $provider($this->app);
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

            foreach ($this->loadedProviders as $provider) {
                $this->log->info('Registering provider: ' . $provider->getName());
                $provider->register();
            }
        } catch (Exception $e) {
            $this->log->error("Failed to register providers: " . $e->getMessage());
            throw $e;
        }
    }

    public function boot(): void
    {
        try {
            foreach ($this->loadedProviders as $provider) {
                $this->log->info('Booting provider: ' . $provider->getName());
                $provider->boot();
            }
        } catch (Exception $e) {
            $this->log->error("Failed to boot providers: " . $e->getMessage());
            throw $e;
        }
    }

    public function getName(): string
    {
        return 'AppServiceProvider';
    }
} 