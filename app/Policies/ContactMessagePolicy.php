<?php

namespace App\Policies;

use App\Models\ContactMessage;
use App\Models\User;

class ContactMessagePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isPanelUser($user);
    }

    public function view(User $user, ContactMessage $contactMessage): bool
    {
        return $this->isPanelUser($user);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ContactMessage $contactMessage): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, ContactMessage $contactMessage): bool
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
