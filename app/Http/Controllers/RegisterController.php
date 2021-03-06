<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Services\RegisterService;
use App\Http\Controllers\Controller;
use App\Http\Services\Validadores\RegisterValidador;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    private RegisterService $registerService;
    private RegisterValidador $validador;

    public function __construct(RegisterService $registerService, RegisterValidador $registerValidador)
    {
        $this->registerService = $registerService;
        $this->validador = $registerValidador;
    }

    public function register(Request $request)
    {
        $validador = $this->validador->validar($request);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        }

        try {
           $user = $this->registerService->registrar($validador->validated());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Preencha todos os campos.'], 400);
        } 
        return response()->json([
            'status' => 'cadastrado',
            'conteudo' => $user,
            'mensagem' => 'Usuário cadastrado com sucesso.'
        ], 201);
    }

}
