<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Enums\TransactionStatusEnum;

class TransferService
{
    public function __construct(
        protected ExternalService $externalService,
        protected TransactionService $transactionService
    ) {}

    public function transfer(float $value, User $payer, User $payee): Transaction
    {
        $payerWallet = $payer->wallet;
        $payeeWallet = $payee->wallet;

        if ($payerWallet->balance < $value) {
            $this->transactionService->createFailedTransaction($payer, $payee, $value);
            throw new Exception('Saldo insuficiente!');
        }

        if (!$this->externalService->authorizeTransaction()) {
            $this->transactionService->createFailedTransaction($payer, $payee, $value);
            throw new Exception('Transação não autorizada.');
        }

        try {
            $transaction = DB::transaction(function () use ($value, $payer, $payee, $payerWallet, $payeeWallet) {
                $transaction = $this->transactionService->createPendingTransaction($payer, $payee, $value);

                $payerWallet->decrement('balance', $value);
                $payeeWallet->increment('balance', $value);

                $this->transactionService->updateStatus($transaction, TransactionStatusEnum::COMPLETED);

                return $transaction;
            });

            $this->externalService->notifyUser();

            return $transaction;
        } catch (\Throwable $th) {
            return $this->transactionService->createFailedTransaction($payer, $payee, $value);
        }
    }
}
