<?php

namespace App\Framework;

use App\Core\Container;
use App\Helpers\PathHelper;

class Application extends Container
{
    protected $basePath;

    public function __construct($basePath)
    {
        parent::__construct();
        $this->basePath = $basePath;
        $this->bootstrapApplication();
    }

    protected function bootstrapApplication()
    {
        PathHelper::setBasePath($this->basePath);
        
        // Passiamo una closure che ritorna $this
        $this->singleton(static::class, function() {
            return $this;
        });
    }
}