<?php

namespace App\Framework;

use LoggerConfig;
use ReflectionClass;
use ReflectionException;
use InvalidArgumentException;

class Container
{
    protected array $bindings = [];
    protected array $instances = [];
    protected array $aliases = [];
    protected array $contextualBindings = [];

    // Metodo per registrare i servizi con supporto per contesti
    public function bind(string $abstract, callable|string $concrete, bool $singleton = false, array $context = []): void
    {
        $this->validateAbstract($abstract);
        
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'singleton' => $singleton,
            'context' => $context
        ];
    }

    // Aggiunge supporto per alias
    public function alias(string $abstract, string $alias): void
    {
        $this->validateAbstract($abstract);
        $this->validateAbstract($alias);

        $this->aliases[$alias] = $abstract;
    }

    public function get(string $abstract)
    {
        return $this->resolve($this->getAlias($abstract));
    }

    public function singleton(string $abstract, callable|string $concrete): void
    {
        $this->bind($abstract, $concrete, true);
    }   

    // Aggiunge binding contestuali
    public function when(string $concrete): ContextualBindingBuilder
    {
        return new ContextualBindingBuilder($this, $concrete);
    }

    protected function getAlias(string $abstract): string
    {
        return $this->aliases[$abstract] ?? $abstract;
    }

    protected function validateAbstract(string $abstract): void
    {
        if (empty($abstract)) {
            throw new InvalidArgumentException('Il nome del binding non può essere vuoto');
        }
    }

    public function resolve(string $abstract)
    {
        try {
            $abstract = $this->getAlias($abstract);

            if (isset($this->instances[$abstract])) {
                return $this->instances[$abstract];
            }

            $concrete = $this->bindings[$abstract]['concrete'] ?? $abstract;
            $context = $this->bindings[$abstract]['context'] ?? [];

            $object = ($concrete instanceof \Closure) 
                ? $concrete($this) 
                : $this->resolveWithAutowiring($concrete, $context);

            if (isset($this->bindings[$abstract]['singleton']) && $this->bindings[$abstract]['singleton']) {
                $this->instances[$abstract] = $object;
            }

            return $object;
        } catch (\Exception $e) {
            $log = LoggerConfig::getLogger();
            $log->error("Errore nella risoluzione della dipendenza: " . $e->getMessage());
            throw $e;
        }
    }

    protected function resolveWithAutowiring(string $concrete, array $context = [])
    {
        try {
            $reflector = new ReflectionClass($concrete);

            if (!$reflector->isInstantiable()) {
                throw new \Exception("La classe $concrete non può essere istanziata.");
            }

            $constructor = $reflector->getConstructor();

            if (is_null($constructor)) {
                return new $concrete;
            }

            $parameters = $constructor->getParameters();
            $dependencies = array_map(function ($parameter) use ($context, $concrete) {
                $type = $parameter->getType();

                if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                    $dependencyClass = $type->getName();
                    
                    // Controlla se esiste un binding contestuale
                    if (isset($context[$parameter->name])) {
                        return $this->resolve($context[$parameter->name]);
                    }
                    
                    if (isset($this->contextualBindings[$concrete][$dependencyClass])) {
                        return $this->resolve($this->contextualBindings[$concrete][$dependencyClass]);
                    }

                    return $this->resolve($dependencyClass);
                }

                if ($parameter->isDefaultValueAvailable()) {
                    return $parameter->getDefaultValue();
                }

                throw new \Exception("Impossibile risolvere la dipendenza {$parameter->name}.");
            }, $parameters);

            return $reflector->newInstanceArgs($dependencies);
        } catch (ReflectionException $e) {
            $log = LoggerConfig::getLogger();
            $log->error("Errore nell'autowiring: " . $e->getMessage());
            throw $e;
        }
    }

    public function getSingletons(): array
    {
        $log = LoggerConfig::getLogger();
        $formattedInstances = json_encode($this->instances, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $log->info("Singletons nel Container:\n" . $formattedInstances);
        
        return $this->instances;
    }

    // Aggiunge binding contestuale
    public function addContextualBinding(string $concrete, string $abstract, string $implementation): void
    {
        $this->contextualBindings[$concrete][$abstract] = $implementation;
    }

    public function make(string $abstract)
    {
        if (!isset($this->bindings[$abstract])) {
            throw new \Exception("No binding registered for {$abstract}");
        }

        $concrete = $this->bindings[$abstract]['concrete'];
        $isSingleton = $this->bindings[$abstract]['singleton'] ?? false;

        if ($isSingleton && isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        $instance = is_callable($concrete) ? $concrete($this) : $concrete;

        if ($isSingleton) {
            $this->instances[$abstract] = $instance;
        }

        return $instance;
    }
}

// Classe helper per i binding contestuali
class ContextualBindingBuilder
{
    protected Container $container;
    protected string $concrete;

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
