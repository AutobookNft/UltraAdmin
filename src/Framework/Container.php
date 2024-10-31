<?php

namespace Fabio\UltraAdmin\Framework;

use ReflectionClass;
use ReflectionException;

class Container
{
    protected array $bindings = [];
    protected array $instances = [];

    // Metodo per registrare i servizi
    public function bind(string $abstract, callable|string $concrete, bool $singleton = false): void
    {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'singleton' => $singleton,
        ];
    }

    // Aggiungi questo metodo nella classe Container
    public function get(string $abstract)
    {
        return $this->resolve($abstract);
    }


    // Metodo per risolvere i servizi
    public function resolve(string $abstract)
    {
        // Se il servizio è un singleton ed è già stato creato, restituiamo l'istanza
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Recupera la definizione del servizio
        $concrete = $this->bindings[$abstract]['concrete'] ?? $abstract;

        if ($concrete instanceof \Closure) {
            $object = $concrete($this);
        } else {
            $object = $this->resolveWithAutowiring($concrete);
        }

        // Se è un singleton, salva l'istanza
        if (isset($this->bindings[$abstract]['singleton']) && $this->bindings[$abstract]['singleton']) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    protected function resolveWithAutowiring(string $concrete)
    {
        // Usa il ReflectionClass per risolvere automaticamente le dipendenze del costruttore
        $reflector = new \ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("La classe $concrete non può essere istanziata.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();
        $dependencies = array_map(function ($parameter) {
            $dependency = $parameter->getClass();
            if ($dependency === null) {
                // Se il parametro non è un tipo classe, controlliamo se ha un valore di default
                if ($parameter->isDefaultValueAvailable()) {
                    return $parameter->getDefaultValue();
                }
                throw new \Exception("Impossibile risolvere la dipendenza {$parameter->name}.");
            }
            return $this->resolve($dependency->name);
        }, $parameters);

        return $reflector->newInstanceArgs($dependencies);
    }
}
