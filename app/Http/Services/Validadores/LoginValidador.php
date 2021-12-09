<?php 
namespace App\Http\Services\Validadores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginValidador
{
    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O email ja esta sendo utilizado.'
        ]);

        return $validator;
    }
}