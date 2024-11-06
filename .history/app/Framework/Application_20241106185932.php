<?php

namespace App\Framework;

use App\Core\Container;
use App\Helpers\PathHelper;
use App\Config\LoggerConfig;

class Application extends Container
{
    protected $basePath;
    protected $log;

    public function __construct($basePath)
    {
        parent::__construct();
        
        $this->basePath = $basePath;
        $this->log = LoggerConfig::getLogger();
        
        $this->bootstrapApplication();
    }

    protected function bootstrapApplication(): void
    {
        $this->log->info('Bootstrapping application');
        
        // Imposta il path base
        PathHelper::setBasePath($this->basePath);
        
        // Registra l'istanza dell'applicazione
        $this->singleton(self::class, function() {
            return $this;
        });
        
        
        
        $this->log->info('Application bootstrapped successfully');
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }
}