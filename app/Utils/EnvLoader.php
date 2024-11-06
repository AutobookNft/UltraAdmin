<?php

namespace App\Utils;

class EnvLoader
{
    private static array $variables = [];

    /**
     * Carica le variabili dal file .env.
     *
     * @param string $filePath Percorso del file .env
     * @return void
     */
    public static function load(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \Exception(".env file not found at: " . $filePath);
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Ignora i commenti
            }

            [$name, $value] = explode('=', $line, 2);
            self::$variables[trim($name)] = trim($value);
        }
    }

    /**
     * Ottieni il valore di una variabile specifica.
     *
     * @param string $key Nome della variabile
     * @param mixed $default Valore di default se la variabile non esiste
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return self::$variables[$key] ?? $default;
    }
}
