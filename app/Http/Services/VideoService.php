<?php 

namespace App\Http\Services;

use App\Models\Video;

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

    
}