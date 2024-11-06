<?php

namespace App\Framework;

use App\Core\Container;

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
        $this->singleton(static::class, $this);
    }
} 