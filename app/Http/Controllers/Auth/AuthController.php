<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthStoreRequest;

class AuthController extends Controller
{
    public function login(AuthStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Usuário desativado.'], 403);
        }

        $user->tokens()->delete();
        $token = $user->createToken("{$user->name}-token")->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response);
    }

    public function logout(): JsonResponse
    {
        $user = User::find(Auth::id());
        $user->tokens()->delete();

        return response()->json(['message' => 'Logout efetuado com sucesso!']);
    }
}
