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

    // Metodo per risolvere i servizi
    public function resolve(string $abstract)
    {
        // Se il servizio è un singleton ed è già stato creato, restituiamo l'istanza
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Recupera la definizione del servizio
        $concrete = $this->bindings[$abstract]['concrete'] ?? $abstract;

        // Risolve l'implementazione concreta
        $object = $this->resolveWithAutowiring($concrete);

        // Se è un singleton, salva l'istanza
        if (isset($this->bindings[$abstract]['singleton']) && $this->bindings[$abstract]['singleton']) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    // Metodo per l'autowiring
    protected function resolveWithAutowiring(string $concrete)
    {
        try {
            $reflector = new ReflectionClass($concrete);
        } catch (ReflectionException $e) {
            throw new \Exception("Cannot resolve {$concrete}: " . $e->getMessage());
        }

        // Se la classe non è instanziabile, lancia un'eccezione
        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$concrete} is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        // Se non esiste un costruttore, istanzia semplicemente la classe
        if (is_null($constructor)) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        // Risolve tutte le dipendenze del costruttore
        foreach ($parameters as $parameter) {
            $dependencyClass = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? new ReflectionClass($parameter->getType()->getName())
                : null;

            if ($dependencyClass === null) {
                // Nel caso non ci siano informazioni sufficienti per risolvere la dipendenza
                throw new \Exception("Cannot resolve the dependency {$parameter->getName()} of class {$concrete}");
            }

            $dependencies[] = $this->resolve($dependencyClass->getName());
        }

        // Restituisce l'istanza della classe richiesta, passando tutte le dipendenze risolte
        return $reflector->newInstanceArgs($dependencies);
    }
}
