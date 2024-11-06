<?php

namespace App\Helpers;

class ViteHelper
{
    public static function assets(): string
    {
        $isDevelopment = true; // TODO: usa $_ENV['APP_ENV'] === 'local'

        if ($isDevelopment) {
            return <<<HTML
                <script type="module" src="http://localhost:5173/@vite/client"></script>
                <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
                <link rel="stylesheet" href="http://localhost:5173/resources/css/app.css">
            HTML;
        }

        // In production
        return <<<HTML
            <script type="module" src="/build/assets/app.js"></script>
            <link rel="stylesheet" href="/build/assets/app.css">
        HTML;
    }
} 