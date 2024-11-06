<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    
    // Metodi specifici per la gestione utenti
    public function findByEmail(string $email);
    public function updateLastLogin(int $id);
    public function updateSecuritySettings(int $id, array $settings);
} 