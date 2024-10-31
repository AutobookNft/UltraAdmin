<?php

namespace Fabio\UltraAdmin\Controllers;

use Fabio\UltraAdmin\Framework\Connect;
use LoggerConfig;

class LibraryController
{
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
        // Esempio di dati che potrebbero essere passati alla vista
        $data = [
            'libraries' => ['Libreria 1', 'Libreria 2', 'Libreria 3']
        ];

        $log = LoggerConfig::getLogger();
        $log->info('dentro LibraryController.php index', ['data'=>$data]);

        // Renderizza la vista library_handler.php
        $this->render('library_handler.html', $data);
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


