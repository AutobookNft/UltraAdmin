<?php

namespace Fabio\UltraAdmin\Providers;

use Fabio\UltraAdmin\Framework\Container;
use Fabio\UltraAdmin\UConfig\UConfig;

class UConfigServiceProvider
{
    protected Container $container;

    /**
     * Costruttore del provider, accetta un'istanza di Container
     *
     * @param Container $container
     */
    public function __construct(Container $container)
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
        $this->container->bind(UConfig::class, function () {
            return new UConfig();
        }, true); // true per registrarlo come singleton
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
