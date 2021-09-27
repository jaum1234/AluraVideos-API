<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegistroFormRequest;

class AuthService 
{  
    public function logar(array $credenciais)
    {
        $token = Auth::attempt($credenciais);
        if (!$token) {
            throw new \Exception('Dados incorretos');
        }

        return $token;
    }

    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O email ja esta sendo utilizado.'
        ]);

        return $validator;
    }

}