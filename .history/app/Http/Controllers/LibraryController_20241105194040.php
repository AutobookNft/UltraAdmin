<?php

namespace App\Http\Controllers;

use Fabio\UltraAdmin\Framework\Connect;
use LoggerConfig;
use Fabio\UltraAdmin\Repositories\LibraryRepository;
use Fabio\UltraAdmin\Framework\DatabaseConnection;
use Exception;

class LibraryController
{
    protected LibraryRepository $libraryRepository;
    
    public function __construct()
    {
        $this->libraryRepository = new LibraryRepository();
    }

    protected function render(string $view, array $data = [])
    {
        // Estrae i dati passati come variabili
        extract($data);
        
        // Percorso alla cartella delle viste
        $viewPath = __DIR__ . "/../../resources/views/{$view}";
        $log = LoggerConfig::getLogger();
        $log->info('viewPath', ['viewPath'=>$viewPath]);

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "Vista non trovata: {$view}";
        }
    }

    public function home()
    {
        
        $log = LoggerConfig::getLogger();
        $log->info('Caricamento della homepage');

        // Renderizza la vista della homepage
        $this->render('home.html');
    }

    public function index()
    {
        try {
            
            $log = LoggerConfig::getLogger();
            $libraries = $this->libraryRepository->getAllLibraries();
            
            $log->info('Recupero librerie completato', ['count' => count($libraries)]);
            
            $this->render('library_handler.html', [
                'libraries' => $libraries,
                'error' => null
            ]);

        } catch (Exception $e) {
            $log->error('Errore nel recupero delle librerie', ['error' => $e->getMessage()]);
            
            $this->render('library_handler.html', [
                'libraries' => [],
                'error' => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        $this->render('create');
    }

    public function store()
    {
        echo "Salva una nuova libreria.";
        // Qui potresti salvare una nuova libreria
    }

    public function edit()
    {
        $this->render('edit', ['library' => 'Nome della libreria']);
    }

    public function update()
    {
        echo "Aggiorna una libreria esistente.";
        // Qui potresti aggiornare i dati
    }

    public function delete()
    {
        echo "Elimina una libreria.";
        // Qui potresti eliminare una libreria
    }

}


