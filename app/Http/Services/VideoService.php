<?php 

namespace App\Http\Services;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoService 
{
    public function atualizar(array $dados, Video $video) 
    {
        $video->titulo = $dados['titulo'];
        $video->descricao = $dados['descricao'];
        $video->url = $dados['url'];
        $video->categoria_id = $dados['categoria_id'];

        $video->save();

        return $video;
    }

    public function excluir(Video $video)
    {
        $video->delete();
        return $video->titulo;
    }

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