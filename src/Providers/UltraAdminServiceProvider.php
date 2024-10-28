<?php

namespace Fabio\UltraAdmin\Providers;

use Fabio\UltraAdmin\Framework\ServiceProvider;
use Fabio\UltraAdmin\Services\LibraryService;

class UltraAdminServiceProvider extends ServiceProvider
{
    /**
     * Register all services.
     *
     * @return void
     */
    public function register(): void
    {
        // Registrazione del servizio per il LibraryService
        $this->app->bind(LibraryService::class, function () {
            return new LibraryService();
        });

        // Aggiungere qui altri servizi, come ad esempio ConfigManager o LogManager
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Avvia eventuali configurazioni, eventi, ecc.
        // Inizializziamo, ad esempio, il LibraryService per impostare alcune configurazioni di base
        $libraryService = $this->app->resolve(LibraryService::class);
        $libraryService->initialize();
    }
}
