<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistroFormRequest;

class AuthService 
{
    public function registrar(RegistroFormRequest $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
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

}