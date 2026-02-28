<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(): JsonResponse
    {
        return response()->json(User::with('roles')->paginate());
    }

    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data);
        $user->assignRole($data['role']);

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->update(['is_active' => false]);

        return response()->json(['message' => 'Usuário desativado com sucesso.']);
    }
}
