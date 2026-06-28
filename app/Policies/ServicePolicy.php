<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isPanelUser($user);
    }

    public function view(User $user, Service $service): bool
    {
        return $this->isPanelUser($user);
    }

    public function create(User $user): bool
    {
        return $this->isPanelUser($user);
    }

    public function update(User $user, Service $service): bool
    {
        return $this->isPanelUser($user);
    }

    public function delete(User $user, Service $service): bool
    {
        return $user->role === 'admin';
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    private function isPanelUser(User $user): bool
    {
        return in_array($user->role, ['admin', 'marketer'], true);
    }
}
