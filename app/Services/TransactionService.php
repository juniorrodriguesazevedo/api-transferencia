<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Enums\TransactionStatusEnum;

class TransactionService
{
    public function createTransaction(User $payer, User $payee, float $value, TransactionStatusEnum $status): Transaction
    {
        return Transaction::create([
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
            'value' => $value,
            'status' => $status,
        ]);
    }

    public function createCompletedTransaction(User $payer, User $payee, float $value): Transaction
    {
        return $this->createTransaction($payer, $payee, $value, TransactionStatusEnum::COMPLETED);
    }

    public function createFailedTransaction(User $payer, User $payee, float $value): Transaction
    {
        return $this->createTransaction($payer, $payee, $value, TransactionStatusEnum::FAILED);
    }

    public function createPendingTransaction(User $payer, User $payee, float $value): Transaction
    {
        return $this->createTransaction($payer, $payee, $value, TransactionStatusEnum::PENDING);
    }

    public function updateStatus(Transaction $transaction, TransactionStatusEnum $status): void
    {
        $transaction->update(['status' => $status]);
    }
}
