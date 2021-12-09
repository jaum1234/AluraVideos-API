<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Categoria;
use App\Http\Services\CategoriaService;
use App\Http\Controllers\BaseController;
use App\Http\Services\Validadores\CategoriaValidador;

Class CategoriaController extends BaseController
{
    
    public function __construct(CategoriaService $categoriaService, CategoriaValidador $categoriaValidador)
    {
        $this->classeService = $categoriaService;
        $this->validador = $categoriaValidador;
        $this->classe = Categoria::class;
    }
    
    public function videoPorCategoria(int $id)
    {
        try {
            $videos = $this->classeService->buscarVideoPorCategoria($id);
        } catch (\DomainException $e) {
            return response()->json(['erro' => $e->getMessage()], 404);
        }
        
        return response()->json([
            'status' => 'listado',
            'conteudo' => $videos,
            'mensagem' => 'Todos os videos da categoria de id ' . $id . ' foram listados.'
        ], 200);
    }
}