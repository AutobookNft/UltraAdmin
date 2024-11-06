<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function updateLastLogin(int $id)
    {
        $user = $this->find($id);
        $user->last_login_at = now();
        $user->save();
        return $user;
    }

    public function updateSecuritySettings(int $id, array $settings)
    {
        $user = $this->find($id);
        $user->security_settings = $settings;
        $user->save();
        return $user;
    }
} 