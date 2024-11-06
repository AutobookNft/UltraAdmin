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
        $this->log->info('Bootstrapping application', ['basePath' => $this->basePath]);
        
        // Imposta il path base
        PathHelper::setBasePath($this->basePath);
        
        // Registra l'istanza dell'applicazione nel container
        $this->singleton(self::class, function() {
            return $this;
        });
        
        // Registra il Router come singleton usando getInstance()
        $this->singleton(Router::class, function() {
            $router = Router::getInstance();
            $this->log->info('Router instance created');
            return $router;
        });
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }
}