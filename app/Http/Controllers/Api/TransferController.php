<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\RoleEnum;
use App\Mail\NotificationMail;
use App\Services\TransferService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Transfers\TransferStoreRequest;

class TransferController extends Controller
{
    public function __construct(protected TransferService $transferService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(TransferStoreRequest $request)
    {
        $payer = User::find(Auth::id());
        $data = $request->validated();
        $payee = User::find($data['payee']);

        if ($payer->role_id === RoleEnum::SHOPKEEPER) {
            return response()->json(['error' => 'Ação não autorizada. Lojistas não podem realizar transferências.'], 403);
        }

        if ($data['value'] > $payer->balance) {
            return response()->json(['error' => 'Saldo insuficiente para realizar a transferência.'], 400);
        }

        if ($this->transferService->authorizeTransfer() !== 'Autorizado') {
            return response()->json(['error' => 'A transferência foi recusada pelo serviço autorizador.'], 403);
        }

        DB::beginTransaction();

        try {
            $payer->balance -= $data['value'];
            $payee->balance += $data['value'];

            $payer->save();
            $payee->save();

            if ($this->transferService->notificationResponse() === true) {
                Mail::to($payee->email)->queue(new NotificationMail($payer, $data['value']));
            }

            DB::commit();

            return response()->json(['success' => 'Transferência realizada com sucesso.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Ocorreu um erro ao processar a transferência.'], 500);
        }
    }
}
