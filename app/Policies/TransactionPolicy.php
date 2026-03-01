<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\RoleEnum;
use App\Models\Transaction;

class TransactionPolicy
{
    public function view(User $user, Transaction $transaction): bool
    {
        return $transaction->payer_id === $user->id || $transaction->payee_id === $user->id;
    }

    public function before(User $user, $ability)
    {
        if ($user->hasRole(RoleEnum::SUPER_ADMIN)) {
            return true;
        }
    }
}
