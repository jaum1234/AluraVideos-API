<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaFormRequest;
use App\Http\Requests\VideoFormRequest;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use App\Http\Services\BuscadorQuery;
use App\Http\Services\CategoriaService;
use InvalidArgumentException;

Class CategoriaController extends Controller
{
    use BuscadorQuery;

    private CategoriaService $categoriaService;

    public function __construct()
    {
        $this->categoriaService = new CategoriaService();
    }
    

    public function index(Request $request)
    {
        $requestTemQuery = $request->has('q');
        
        if ($requestTemQuery) {
            $resultadoQuery = $this->buscarQuery(Categoria::class);
            return response()->json($resultadoQuery);
        }

        $categorias = $this->categoriaService->buscarTodosAsCategorias($request->per_page);

        return response()->json($categorias);
    }

    public function store(CategoriaFormRequest $request)
    {
        try {
            $recurso = $this->categoriaService->criarCategoria($request);
        } catch (QueryException $e) {
            return response()->json("Os campo nao foram preenchidos corretamente", 404);
        }

        return response()->json($recurso, 201);
    }

    public function show(int $id)
    {   
        try {
            $categoria = $this->categoriaService->buscarCategoria($id);
        } catch (\DomainException $e) {
            return response()->json($e->getMessage(), 404);
        }

        return response()->json($categoria, 200);
    }

    public function delete($id)
    {
        try {
            $recurso = $this->categoriaService->excluirCategoria($id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 403);
        } catch (\DomainException $e) {
            return response()->json($e->getMessage(), 404);
        }
        
        return response()->json($recurso . ' excluido', 410);
    }

    public function update(CategoriaFormRequest $request, int $id)
    {
        try {
            $categoria = $this->categoriaService->atualizarCategoria($request ,$id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 403);
        } catch (\DomainException $e) {
            return response()->json($e->getMessage(), 404);
        }

        return response()->json($categoria ,201);
    }

    public function videoPorCategoria(int $id)
    {
        try {
            $videos = $this->categoriaService->buscarVideoPorCategoria($id);
        } catch (\DomainException $e) {
            return response()->json($e->getMessage(), 404);
        }
        return response()->json($videos);
    }
}