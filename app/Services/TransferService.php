<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TransferService
{
    public function authorizeTransfer(): string
    {
        return Http::get('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc')['message'];
    }

    public function notificationResponse(): bool
    {
        return Http::get('https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6')['message'];
    }
}
