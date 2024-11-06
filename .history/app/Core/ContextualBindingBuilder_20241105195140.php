<?php

namespace App\Framework;

class ContextualBindingBuilder
{
    protected Container $container;
    protected string $concrete;
    protected string $abstract;

    public function __construct(Container $container, string $concrete)
    {
        $this->container = $container;
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