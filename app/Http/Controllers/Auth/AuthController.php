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
        $user = User::firstWhere('email', $data['email']);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Dados incorretos'], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken("$user->name - $user->email")->plainTextToken;

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
