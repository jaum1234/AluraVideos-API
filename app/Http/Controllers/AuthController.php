<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    private UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function register(Request $request)
    {
        $validador = $this->service->validar($request);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        }

        try {
           $user = $this->service->registrar($validador->validated());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Preencha todos os campos.'], 400);
        }
        return response()->json([
            'status' => 'cadastrado',
            'conteudo' => $user,
            'mensagem' => 'Usuário cadastrado com sucesso.'
        ], 201);
    }

    public function login(Request $request)
    {
        $validador = $this->service->validar($request);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        }
        
        try {
            $token = $this->service->logar($validador->validated());
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 401);
        }
        
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
