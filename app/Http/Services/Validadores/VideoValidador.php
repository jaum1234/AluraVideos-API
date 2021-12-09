<?php 
namespace App\Http\Services\Validadores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoValidador
{
    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descricao' => 'required',
            'url' => 'required',
            'categoria_id' => 'required'
        ], [
            'required' => 'O campo :attribute é obrigatório.'
        ]);

        return $validator;
    }
}