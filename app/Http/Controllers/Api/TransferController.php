<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\TransferService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;

class TransferController extends Controller
{
    public function __construct(protected TransferService $transferService) {}

    public function __invoke(TransferRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $payer = User::find($data['payer']);
            $payee = User::find($data['payee']);

            $this->authorize('makeTransfer', $payer);
            $this->transferService->transfer($data['value'], $payer, $payee);

            return response()->json(['messagem' => 'Transferência realizada com sucesso!'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 403);
        }
    }
}
