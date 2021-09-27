<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegistroFormRequest;

class UserService 
{
    public function registrar(array $dados)
    {
        $user = new User();

        $user->name = $dados['name'];
        $user->password = Hash::make($dados['password']);
        $user->email = $dados['email'];
        $user->save();

        return $user;
    }
    
    public function logar($credenciais)
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
            'name' => 'required|sometimes',
            'email' => 'required',
            'password' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.'
        ]);

        return $validator;
    }

}