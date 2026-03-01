<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\TransactionStatusEnum;

class TransferService
{
    public function __construct(
        protected ExternalService $externalService,
        protected TransactionService $transactionService
    ) {}

    public function transfer(float $value, User $payer, User $payee): Transaction
    {
        $this->ensureSufficientBalance($payer, $payee, $value);
        $this->authorizeTransaction($payer, $payee, $value);

        try {
            $transaction = $this->processTransaction($payer, $payee, $value);
            $this->notifyUser($transaction);

            return $transaction;
        } catch (\Throwable $th) {
            return $this->transactionService->createFailedTransaction($payer, $payee, $value);
        }
    }

    private function ensureSufficientBalance(User $payer, User $payee, float $value): void
    {
        if ($payer->wallet->balance < $value) {
            $this->transactionService->createFailedTransaction($payer, $payee, $value);
            throw new Exception('Saldo insuficiente!');
        }
    }

    private function authorizeTransaction($payer, $payee, $value): void
    {
        if (!$this->externalService->authorizeTransaction()) {
            $this->transactionService->createFailedTransaction($payer, $payee, $value);
            throw new Exception('Transação não autorizada.');
        }
    }

    private function processTransaction(User $payer, User $payee, float $value): Transaction
    {
        return DB::transaction(function () use ($payer, $payee, $value) {
            $transaction = $this->transactionService->createPendingTransaction($payer, $payee, $value);

            $payer->wallet->decrement('balance', $value);
            $payee->wallet->increment('balance', $value);

            $this->transactionService->updateStatus($transaction, TransactionStatusEnum::COMPLETED);

            return $transaction;
        });
    }

    private function notifyUser(Transaction $transaction): void
    {
        if (!$this->externalService->notifyUser()) {
            Log::channel('notify_user')->warning(
                "Notificação da transferência falhou para Transação ID {$transaction->id}"
            );
        }
    }
}
