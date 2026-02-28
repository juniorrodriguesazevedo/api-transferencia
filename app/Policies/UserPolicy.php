<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\RoleEnum;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleEnum::SUPER_ADMIN);
    }

    public function view(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id;
    }

    public function create(?User $user): bool
    {
        return true;
    }

    public function update(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id;
    }

    public function delete(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id;
    }

    public function before(User $user, string $ability)
    {
        if ($user->hasRole(RoleEnum::SUPER_ADMIN)) {
            return true;
        }
    }
}
