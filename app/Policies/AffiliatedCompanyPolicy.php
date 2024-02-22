<?php

namespace App\Policies;

use App\Models\User;

class AffiliatedCompanyPolicy
{
    public function index(User $user)
    {
        return $user->rol === 'Administrador';
    }

    public function store(User $user)
    {
        return $user->rol === 'Administrador';
    }

    public function show(User $user)
    {
        return $user->rol === 'Administrador';
    }

    public function update(User $user)
    {
        return $user->rol === 'Administrador';
    }

    public function delete(User $user)
    {
        return $user->rol === 'Administrador';
    }
}
