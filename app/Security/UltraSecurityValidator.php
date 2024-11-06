<?php

namespace App\Security;

class UltraSecurityValidator
{
    private const FORBIDDEN_PATTERNS = [
        '/\b(eval|exec|system|shell_exec|passthru)\b/i',
        '/\b(__FILE__|__DIR__)\b/',
        '/\$_(GET|POST|REQUEST|FILES|SERVER|ENV|COOKIE|SESSION)/',
        '/include|require|include_once|require_once/',
    ];

    public function isFileSecure(string $filePath): bool
    {
        if (!is_file($filePath) || !is_readable($filePath)) {
            return false;
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            return false;
        }

        // Verifica pattern pericolosi
        foreach (self::FORBIDDEN_PATTERNS as $pattern) {
            if (preg_match($pattern, $content)) {
                return false;
            }
        }

        // Verifica la struttura del file
        $ast = @token_get_all($content);
        if ($ast === false) {
            return false;
        }

        return $this->validateAst($ast);
    }

    private function validateAst(array $ast): bool
    {
        $returnFound = false;
        $arrayOnly = true;

        foreach ($ast as $token) {
            if (is_array($token)) {
                [$id, $text] = $token;
                
                // Permetti solo return array
                if ($id === T_RETURN) {
                    if ($returnFound) {
                        return false; // Multiple returns not allowed
                    }
                    $returnFound = true;
                }
                
                // Blocca funzioni e classi
                if (in_array($id, [T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT])) {
                    return false;
                }
            }
        }

        return $returnFound && $arrayOnly;
    }
} 