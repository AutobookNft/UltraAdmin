<?php

namespace App\Providers;

use App\Framework\Container;
use Fabio\UltraAdmin\Services\UltraTranslator;
use Fabio\UltraAdmin\Security\UltraSecurityValidator;

class TranslationServiceProvider
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function register()
    {
        // Registra il validator come singleton
        $this->container->bind(UltraSecurityValidator::class, function() {
            return new UltraSecurityValidator();
        }, true);

        // Registra il translator come singleton
        $this->container->bind(UltraTranslator::class, function($container) {
            return new UltraTranslator(
                $container->make(UltraSecurityValidator::class),
                'it',
                'it'
            );
        }, true);

        // Registra l'alias per la funzione helper
        if (!function_exists('__')) {
            $container = $this->container;
            global $ultraContainer;
            $ultraContainer = $container;
            
            // Define function in global scope
        }
    }

    public function boot()
    {
        // Carica eventuali configurazioni aggiuntive
        $config = require __DIR__ . '/../../config/translator.php';
        
        $translator = $this->container->make(UltraTranslator::class);
        if (isset($config['default_locale'])) {
            $translator->setLocale($config['default_locale']);
        }
    }
} 