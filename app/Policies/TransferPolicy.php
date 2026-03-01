<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferPolicy
{
    use HandlesAuthorization;

    public function makeTransfer(User $authUser, User $payer): bool
    {
        if ($authUser->id !== $payer->id) {
            return false;
        }

        if ($authUser->hasRole(RoleEnum::SHOPKEEPER)) {
            return false;
        }

        return true;
    }
}
