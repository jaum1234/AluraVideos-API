<?php 
namespace App\Http\Services\Validadores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterValidador
{
    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|unique:users,email|string',
            'password' => 'required|string',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O email ja esta sendo utilizado.'
        ]);

        return $validator;
    }
}