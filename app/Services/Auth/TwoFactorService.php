<?php

namespace App\Services\Auth;

class TwoFactorService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function generateCode(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function validateCode(string $userCode, string $storedCode): bool
    {
        return hash_equals($storedCode, $userCode);
    }

    public function sendCode(string $code, string $to): bool
    {
        // Implementazione dell'invio del codice
        // Potrebbe utilizzare email, SMS, ecc.
        return true;
    }

    public function isEnabled(int $userId): bool
    {
        // Verifica se 2FA è abilitato per l'utente
        return true;
    }
} 