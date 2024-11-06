<?php

namespace App\Framework;

class Application
{
    protected $basePath;
    protected $bindings = [];
    
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function singleton($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function make($abstract)
    {
        if (isset($this->bindings[$abstract])) {
            if (is_callable($this->bindings[$abstract])) {
                return call_user_func($this->bindings[$abstract], $this);
            }
            return $this->bindings[$abstract];
        }
        
        // Se la classe esiste, la istanziamo
        if (class_exists($abstract)) {
            return new $abstract();
        }
        
        throw new \Exception("Class {$abstract} not found");
    }

    public function getBasePath()
    {
        return $this->basePath;
    }
} 