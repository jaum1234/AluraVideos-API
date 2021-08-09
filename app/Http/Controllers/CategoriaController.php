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

Class CategoriaController extends Controller
{
    use BuscadorQuery;

    protected string $classe;
    private CategoriaService $categoriaService;

    public function __construct()
    {
        $this->categoriaService = new CategoriaService;
    }

    public function index(Request $request)
    {
        $requestTemQuery = $request->has('q');
        
        if ($requestTemQuery) {
            $resultadoQuery = $this->buscarQuery(Categoria::class);
            return response()->json($resultadoQuery);
        }

        $recursos = Categoria::paginate($request->per_page);

        return response()->json($recursos);
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

    public function show($id)
    {   
        try {
            $recurso = $this->categoriaService->buscarCategoria($id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 404);
        }

        return response()->json($recurso, 200);
    }

    public function delete($id)
    {
        
        try {
            if ($id == 1) {
                throw new Exception();
            }
        } catch (Exception $e) {
            return response()->json("Essa categoria nao pode ser excluida");
        }
        
        $recurso = $this->categoriaService->excluirCategoria($id);
        
        
        return response()->json('Recurso excluido', 410);
    }

    public function update(CategoriaFormRequest $request, $id)
    {
        try {
            if ($id == 1) {
                throw new Exception();
            }
        } catch (Exception $e) {
            return response()->json("Essa categoria nao pode ser alterada");
        }

        $recursos = Categoria::find($id);
        $recursos->titulo = $request->titulo;
        $recursos->cor = $request->cor;

        $recursos->save();

        return response()->json([
            'titulo' => $recursos->titulo,
            'cor' => $recursos->cor,
        ], 201);
    }

    public function buscarVideoPorCategoria(int $id)
    {
        $categoria = Categoria::find($id);
        $categoria->videos;
        return response()->json($categoria);
    }
}