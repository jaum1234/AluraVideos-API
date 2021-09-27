<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Controllers\BaseController;
use App\Http\Services\CategoriaService;

Class CategoriaController extends BaseController
{
    
    public function __construct(CategoriaService $categoriaService)
    {
        $this->classeService = $categoriaService;
        $this->classe = Categoria::class;
    }
    
    public function videoPorCategoria(int $id)
    {
        try {
            $videos = $this->classeService->buscarVideoPorCategoria($id);
        } catch (\DomainException $e) {
            return response()->json(['erro' => $e->getMessage()], 404);
        }
        
        return response()->json($videos);
    }
}