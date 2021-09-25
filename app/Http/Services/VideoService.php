<?php 

namespace App\Http\Services;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoService 
{
    public function atualizar(Request $request, Video $video) 
    {
        $video->titulo = $request->titulo;
        $video->descricao = $request->descricao;
        $video->url = $request->url;
        $video->categoria_id = $request->categoria_id;

        $video->save();

        return $video;
    }

    public function excluir(Video $video)
    {
        $video->delete();
        return $video->titulo;
    }
}