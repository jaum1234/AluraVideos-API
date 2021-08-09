<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\AuthService;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegistroFormRequest;

class AuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function register(RegistroFormRequest $request)
    {
        try {
            $this->authService->registrar($request);
        } catch (\Exception $e) {
            return response()->json('Dados incorretos', 400);
        }

        return response()->json('Cadastro realizado com sucesso.', 201);
        
    }

    public function login(LoginFormRequest $request)
    {
        
        $credenciais = request(['email', 'password']);
        try {
            $token = $this->authService->logar($credenciais);
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
