<?php

namespace App\Providers;

use App\Core\ServiceProvider;  
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Auth\TwoFactorService;
use App\Services\Logging\UltraLogService;
use App\Services\UltraTranslator;
use App\Security\UltraSecurityValidator;
use App\Helpers\PathHelper;


class UltraAdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registra un alias temporaneo per le classi
        $this->app->alias('Src\Services\UltraTranslator', 'App\Services\UltraTranslator');
        $this->app->alias('Src\Security\UltraSecurityValidator', 'App\Security\UltraSecurityValidator');
        
        // ... altri alias necessari

        $translator = new UltraTranslator(
            new UltraSecurityValidator(),
            'it',
            'en'
        );

        // Registrazione dei repository
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        // Registrazione dei servizi
        $this->app->singleton('ultra.auth', function ($app) {
            return new TwoFactorService($app);
        });

        $this->app->singleton('ultra.log', function ($app) {
            return new UltraLogService($app);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/ultraadmin.php' => PathHelper::configPath('ultraadmin.php'),
        ], 'ultraadmin-config');

        $this->loadRoutesFrom(__DIR__.'/../../routes/admin.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views/admin', 'ultraadmin');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    
} 