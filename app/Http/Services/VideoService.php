<?php 

namespace App\Http\Services;

use App\Http\Requests\VideoFormRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoService 
{
    public function buscarTodosOsVideos($videosPorPagina)
    {
        $videos = Video::paginate($videosPorPagina);
        return $videos;
    }

    public function criarVideo($atributos)
    {
        $video = Video::create($atributos);
        return $video;
    }

    public function buscarVideo($id)
    {
        $video = Video::find($id);

        if (is_null($video)) {
           throw new \Exception("Esse vídeo nao existe");
        };

        return $video;
    }

    public function atualizarVideo(VideoFormRequest $request, int $videoId) 
    {
        $video = Video::find($videoId);

        $video->titulo = $request->titulo;
        $video->descricao = $request->descricao;
        $video->url = $request->url;
        $video->categoria_id = $request->categoria_id;

        $video->save();

        return $video;
    }

    public function excluirVideo($videoId)
    {
        $video = Video::find($videoId);
        
        if (is_null($video)) {
            throw new \Exception('Esse video nao existe.');
        }        
        $video->delete();
        return $video->titulo;
    }

    public function buscarVideosParaUsuarioNaoAutenticado()
    {
        $videos = Video::query()->limit(5)->get();
        return $videos;
    }

}