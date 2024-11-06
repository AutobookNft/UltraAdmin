<?php

namespace App\Core;



class ContextualBindingBuilder
{
    protected Container $app;
    protected string $concrete;
    protected string $abstract;

    public function __construct(Container $app, string $concrete)
    {
        $this->app = $app;
        $this->concrete = $concrete;
    }

    public function needs(string $abstract): self
    {
        $this->abstract = $abstract;
        return $this;
    }

    public function give(string $implementation): void
    {
        $this->app->addContextualBinding(
            $this->concrete,
            $this->abstract,
            $implementation
        );
    }
} 