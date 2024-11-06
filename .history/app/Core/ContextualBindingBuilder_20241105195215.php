<?php

namespace App\Framework;

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
        $this->container->addContextualBinding(
            $this->concrete,
            $this->abstract,
            $implementation
        );
    }
} 