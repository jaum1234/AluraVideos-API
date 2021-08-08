<?php 

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;

class AuthService 
{
    public function logar($credenciais)
    {
        $token = Auth::attempt($credenciais);
        if (!$token) {
            throw new \Exception('Nao autorizado');
        }

        return $token;
    }
}