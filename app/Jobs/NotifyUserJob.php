<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use App\Services\ExternalService;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = 10;

    public function __construct(public Transaction $transaction) {}

    public function handle(ExternalService $externalService)
    {
        $success = $externalService->notifyUser($this->transaction);

        if (!$success) {
            Log::channel('notify_user')->warning(
                "Notificação da transferência falhou para Transação ID {$this->transaction->id}}"
            );
        }
    }
}
