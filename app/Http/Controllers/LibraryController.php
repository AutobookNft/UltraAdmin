<?php
// Questo è codice php

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
        // $this->log->info('viewPath', ['viewPath'=>$viewPath]);

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
            
            // $this->log->info('Recupero librerie completato', ['count' => count($libraries)]);
            
            $this->render('library_handler.php', [
                'libraries' => $libraries,
                'error' => null
            ]);

        } catch (Exception $e) {
            $this->log->error('Errore nel recupero delle librerie', ['error' => $e->getMessage()]);
            
            $this->render('library_handler.php', [
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
        try {
            $result = $this->libraryRepository->create($_POST);
            echo json_encode([
                'success' => true,
                'message' => 'Libreria aggiunta con successo',
                'data' => $result
            ]);
        } catch (Exception $e) {
            $this->log->error('Errore nell\'aggiunta della libreria', ['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $this->log->info('Dentro edit', ['id' => $id]);
        
        try {
            $library = $this->libraryRepository->getLibraryById($id);
            
            header('Content-Type: application/json');
            $this->log->info('Recupero libreria completato', ['data' => $library]);

            echo json_encode([
                'success' => true,
                'data' => $library
            ]);
            
        } catch (Exception $e) {
            $this->log->error('Errore nel recupero della libreria', ['error' => $e->getMessage()]);
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    public function update($id)
    {
        try {
            // Log per debug
            $this->log->info('Update chiamato con:', [
                'id' => $id,
                'post_data' => $_POST
            ]);

            $result = $this->libraryRepository->update($id, $_POST);
            
            // Assicurati che gli headers siano impostati correttamente
            header('Content-Type: application/json');
            
            echo json_encode([
                'success' => true,
                'message' => 'Libreria aggiornata con successo',
                'data' => $result
            ]);
            
        } catch (Exception $e) {
            $this->log->error('Errore in update:', ['error' => $e->getMessage()]);
            
            header('Content-Type: application/json');
            http_response_code(500);
            
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit(); // Importante: ferma l'esecuzione dopo aver inviato la risposta
    }

    public function delete()
    {
        echo "Elimina una libreria.";
        // Qui potresti eliminare una libreria
    }

}


