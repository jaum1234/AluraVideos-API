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
    private VideoService $videoService;

    public function __construct()
    {
        $this->videoService = new VideoService();
    }

    public function index(Request $request)
    {
        $requestTemQuery = $request->has('q');
        
        if ($requestTemQuery) {
            $resultadoQuery = $this->buscarQuery(Video::class);
            return response()->json($resultadoQuery);
        }

        $videos = $this->videoService->buscarTodosOsVideos($request->per_page);
        return response()->json($videos);
    }

    public function store(VideoFormRequest $request)
    {
        $video = $this->videoService->criarVideo($request->all());
        return response()->json($video, 201);
    }

    public function show(int $id)
    {   
        try {
            $video = $this->videoService->buscarVideo($id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 404);
        }

        return response()->json($video);
    }

    public function delete(int $id)
    {
        try {
            $video = $this->videoService->excluirVideo($id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json(['sucesso' => $video . ' foi excluido com sucesso.'], 410);
    }

    public function update(VideoFormRequest $request, int $id)
    {
        try {
            $video = $this->videoService->atualizarVideo($request, $id);
        } catch (QueryException $e) {
            return response()->json(['erro' => 'Os campos nao foram preenchidos corretamente.']);
        }

        return response()->json($video, 200);
    }

    public function livre()
    {
        $videos = $this->videoService->buscarVideosParaUsuarioNaoAutenticado();
        return response()->json($videos);
    }
}