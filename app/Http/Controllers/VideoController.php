<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Services\VideoService;
use App\Http\Services\Validadores\VideoValidador;

Class VideoController extends BaseController
{

    public function __construct(VideoService $videoService, VideoValidador $videoValidador)
    {
        $this->classeService = $videoService;
        $this->validador = $videoValidador;
        $this->classe = Video::class;
    }

    public function livre()
    {
        $videos = Video::query()->limit(5)->get();;
        return response()->json([
            'status' => 'listado',
            'conteudo' => $videos,
            'mensagem' => 'Videos para usuários nao autenticados foram exibidos.'
        ]);
    }
}