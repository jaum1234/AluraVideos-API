<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoFormRequest;
use App\Models\Video;
use Exception;

Class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();

        return response()->json(['videos' => $videos]);
    }

    public function store(VideoFormRequest $request)
    {
        $videos = $request->all();
        $video = Video::create($videos);

        return response()->json(['video' => $video], 201);
    }

    public function show($id)
    {   
        $video = Video::find($id);

        if (is_null($video)) {
            return response()->json([
                'Recurso nao encontrado'
            ], 201);
        };

        return response()->json(['video' => $video]);
    }

    public function update(VideoFormRequest $request, $id)
    {
    
        $video = Video::find($id);
        $video->titulo = $request->titulo;
        $video->descricao = $request->descricao;
        $video->url = $request->url;

        $video->save();

        return response()->json([
            'titulo' => $video->titulo,
            'descricao' => $video->descricao,
            'url' => $video->url,
        ]);
    }

    public function delete($id)
    {
        try {
            $video = Video::find($id);

            if (is_null($video)) {
                throw new Exception();
            }

            $video->delete();
            
        } catch (Exception $e) {
            return response()->json(['Recurso excluido']);
        }
    }
}