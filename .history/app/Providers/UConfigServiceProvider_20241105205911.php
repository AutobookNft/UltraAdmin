<?php

namespace App\Providers;

use App\Core\Container;
use App\UConfig\UConfig;

class UConfigServiceProvider
{
    protected Container $container;

    /**
     * Costruttore del provider, accetta un'istanza di Container
     *
     * @param Container $container
     */
    public function __construct(Container $app)
    {
        $this->container = $container;
    }

    /**
     * Metodo per registrare il service provider
     *
     * Qui registriamo `UConfig` come singleton nel container.
     */
    public function register(): void
    {
        $this->container->singleton(UConfig::class, function () {
            return new UConfig();
        }); 
    }

    /**
     * Metodo di avvio per `UConfig`
     *
     * Qui eseguiamo tutte le configurazioni necessarie per `UConfig`
     * e carichiamo le configurazioni base.
     */
    public function boot(): void
    {
        // Recupera l'istanza di UConfig dal container
        $config = $this->container->resolve(UConfig::class);

        // Esempio di caricamento di configurazioni essenziali
        $config::load('logging');
        $config::load('database');
    }
}
