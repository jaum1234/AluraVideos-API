<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Validadores\LoginValidador;

class AuthController extends Controller
{
    private AuthService $authService;
    private LoginValidador $validador;

    public function __construct(AuthService $authService, LoginValidador $loginValidador)
    {
        $this->authService = $authService;
        $this->validador = $loginValidador;
    }

    public function login(Request $request)
    {
        $validador = $this->validador->validar($request);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        }
        
        try {
            $token = $this->authService->logar($validador->validated());
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
