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
    protected string $classe;

    public function index(BuscadorQuery $buscadorQuery,Request $request)
    {
        if ($request->has('q')) {
            $recurso = $buscadorQuery->buscarQuery(Video::class);
            return response()->json($recurso);
        }

        $recursos = Video::all();

        return response()->json($recursos);
    }

    public function store(VideoFormRequest $request)
    {
        try {
            $recursos = $request->all();
            $recurso = Video::create($recursos);
        } catch (QueryException $e) {
            return response()->json("Os campo nao foram preenchidos corretamente", 404);
        }

        return response()->json($recurso, 201);
    }

    public function show($id)
    {   
        $recursos = Video::find($id);

        if (is_null($recursos)) {
            return response()->json([
                'Recurso nao encontrado'
            ], 404);
        };

        return response()->json($recursos, 200);
    }

    public function delete(VideoService $videoService ,$id)
    {
        $recurso = Video::find($id);
    
        $videoService->excluirVideo($recurso);
        try {
            if (is_null($recurso)) {
                throw new Exception();
            }
        } catch (Exception $e) {
            return response()->json('Recurso nao encontrado', 404);
        }
        
        $recurso->delete();
        return response()->json('Recurso excluido', 410);
    }

    public function update(VideoFormRequest $request, $id)
    {
    
        $recursos = Video::find($id);
        $recursos->titulo = $request->titulo;
        $recursos->descricao = $request->descricao;
        $recursos->url = $request->url;
        $recursos->categoria_id = $request->categoria_id;

        $recursos->save();

        return response()->json([
            'titulo' => $recursos->titulo,
            'descricao' => $recursos->descricao,
            'url' => $recursos->url,
            'categoria_id' => $recursos->categoria_id
        ], 201);
    }
}