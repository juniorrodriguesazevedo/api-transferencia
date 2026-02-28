<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExternalService
{
    public function authorizeTransaction(): bool
    {
        $response = Http::get('https://util.devi.tools/api/v2/authorize');

        if ($response->failed()) {
            return false;
        }

        $data = $response->json();

        return $data['data']['authorization'] ?? false;
    }

    public function notifyUser(): bool
    {
        $response = Http::post('https://util.devi.tools/api/v1/notify');

        if ($response->failed()) {
            return false;
        }

        if ($response->status() === 204) {
            return true;
        }

        return false;
    }
}
