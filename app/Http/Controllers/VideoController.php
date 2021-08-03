<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\BuscadorQuery;
use App\Http\Requests\VideoFormRequest;
use App\Http\Services\VideoService;
use Illuminate\Database\QueryException;
Class VideoController extends Controller
{
    use BuscadorQuery;

    protected string $classe;

    public function index(VideoService $videoService ,Request $request)
    {
        $requestTemQuery = $request->has('q');
        
        if ($requestTemQuery) {
            $resultadoQuery = $this->buscarQuery(Video::class);
            return response()->json($resultadoQuery);
        }

        $videos = $videoService->buscarTodosOsVideos($request->per_page);
        return response()->json($videos);
    }

    public function store(VideoFormRequest $request, VideoService $videoService)
    {
        $video = $videoService->criarVideo($request->all());
        return response()->json($video, 201);
    }

    public function show(VideoService $videoService ,int $id)
    {   
        try {
            $video = $videoService->buscarVideo($id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 404);
        }

        return response()->json($video);
    }

    public function delete(VideoService $videoService , int $id)
    {
        try {
            $video = $videoService->excluirVideo($id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($video . 'foi excluido com sucesso.', 410);
    }

    public function update(VideoFormRequest $request, int $id, VideoService $videoService)
    {
        try {
            $video = $videoService->atualizarVideo(
                $request->titulo, 
                $request->descricao, 
                $request->url,
                $request->categoria_id, 
                $id
            );
        } catch (QueryException $e) {
            return response()->json('Os campos nao foram preenchidos corretamente.');
        }

        return response()->json($video, 200);
    }

    public function total(VideoService $videoService)
    {
        $videos = $videoService->buscarVidosParaUsuarioNaoAutenticado();
        return response()->json($videos);
    }
}