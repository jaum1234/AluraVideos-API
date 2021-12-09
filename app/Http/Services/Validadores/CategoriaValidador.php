<?php 
namespace App\Http\Services\Validadores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaValidador
{
    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string',
            'cor' => 'required|string'
        ], [
            'required' => 'O campo :attribute é obrigatório.'
        ]);

        return $validator;
    }
}