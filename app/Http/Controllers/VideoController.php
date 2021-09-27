<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Services\VideoService;
Class VideoController extends BaseController
{

    public function __construct(VideoService $videoService)
    {
        $this->classeService = $videoService;
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