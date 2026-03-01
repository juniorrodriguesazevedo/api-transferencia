<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $transactions = Transaction::where('payer_id', $user->id)
            ->orWhere('payee_id', $user->id)
            ->with(['payer', 'payee'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return TransactionResource::collection($transactions);
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return TransactionResource::make($transaction->load(['payer', 'payee']));
    }
}
