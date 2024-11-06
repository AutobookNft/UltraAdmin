<?php

namespace App\Http\Controllers;



use App\Repositories\LibraryRepository;
use Exception;
use App\Config\LoggerConfig;
use App\Helpers\PathHelper;

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
        $viewPath = PathHelper::routesView($view);
        $this->log->info('viewPath', ['viewPath'=>$viewPath]);

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {    
            echo "Vista non trovata: {$view}";
        }
    }

    public function home()
    {
        
        
        $this-> log->info('Caricamento della homepage');

        // Renderizza la vista della homepage
        $this->render('home.html');
    }

    public function index()
    {
        try {

            $libraries = $this->libraryRepository->getAllLibraries();
            
            $this->log->info('Recupero librerie completato', ['count' => count($libraries)]);
            
            $this->render('library_handler.html', [
                'libraries' => $libraries,
                'error' => null
            ]);

        } catch (Exception $e) {
            $this->log->error('Errore nel recupero delle librerie', ['error' => $e->getMessage()]);
            
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

    public function edit($id)
    {
        
        try {
            $library = $this->libraryRepository->getLibraryById($id);
        } catch (Exception $e) {
            $this->log->error('Errore nel recupero della libreria', ['error' => $e->getMessage()]);
        }
        
        
        
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


