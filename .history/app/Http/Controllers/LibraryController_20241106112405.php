<?php

namespace App\Http\Controllers;



use App\Repositories\LibraryRepository;
use Exception;
use App\Config\LoggerConfig;

class LibraryController
{
    protected LibraryRepository $libraryRepository;
    protected $log;
    
    public function __construct()
    {
        $this->libraryRepository = new LibraryRepository();
        $this->log = LoggerConfig::getLogger();
    }

    protected function render(string $view, array $data = [])
    {
        // Estrae i dati passati come variabili
        extract($data);
        
        // Percorso alla cartella delle viste
        $viewPath = __DIR__ . "/../../resources/views/{$view}";
        $this->log->info('viewPath', ['viewPath'=>$viewPath]);

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {    
            echo "Vista non trovata: {$view}";
        }
    }

    public function home()
    {
        
        
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


