<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isEditor($user);
    }

    public function view(User $user, Category $category): bool
    {
        return $this->isEditor($user);
    }

    public function create(User $user): bool
    {
        return $this->isEditor($user);
    }

    public function update(User $user, Category $category): bool
    {
        return $this->isEditor($user);
    }

    public function delete(User $user, Category $category): bool
    {
        return $this->isEditor($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->isEditor($user);
    }

    private function isEditor(User $user): bool
    {
        return in_array($user->role, ['admin', 'marketer'], true);
    }
}
