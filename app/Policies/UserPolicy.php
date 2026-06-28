<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, User $model): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, User $model): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, User $model): bool
    {
        if (! $this->isAdmin($user) || $user->is($model)) {
            return false;
        }

        return $model->role !== 'admin' || User::where('role', 'admin')->count() > 1;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    private function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }
}
