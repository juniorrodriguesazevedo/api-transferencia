<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferPolicy
{
    use HandlesAuthorization;

    public function makeTransfer(User $user): bool
    {
        if ($user->hasRole(RoleEnum::SHOPKEEPER)) {
            $this->deny('Lojistas não podem enviar transferências.');
        }

        return true;
    }
}
