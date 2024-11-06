<?php

namespace App\Http\Controllers;


use App\Config\LoggerConfig;
use Exception;

class Home
{
    
    
    public function __construct()
    {
        
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
            $log->info('Caricamento della pagina index');
            
            $this->render('index.html', [
                'error' => null
            ]);

        } catch (Exception $e) {
            $log = LoggerConfig::getLogger();
            $log->error('Errore nel caricamento della pagina index', ['error' => $e->getMessage()]);
            
            $this->render('index.html', [
                'error' => $e->getMessage()
            ]);
        }
    }



}


